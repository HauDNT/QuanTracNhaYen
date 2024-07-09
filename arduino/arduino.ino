// Thêm các thư viện
#include <Adafruit_Sensor.h>
#include <WiFi.h>
#include <ArduinoJson.h>
#include <SPIFFS.h>
#include <HTTPClient.h>
#include <Arduino.h>
#include <AsyncTCP.h>
#include <FS.h>
#include <ESP_Mail_Client.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <NTPClient.h>
#include <WiFiUdp.h>

//________________Thêm các file thư viện được tạo riêng_______________
#include "getSettingsFiles.h"
#include "DHT_Sensor.h"
#include "Flame_Sensor.h"
#include "ConnectWifi.h"
#include "GetConfigStation.h"
#include "SendData.h"
#include "LCD.h"
#include "L298N.h"
#include "LedStatus.h"
#include "SetTimer.h"
#include "ESP_Mailer.h"

//_____________________________________________________________________
Settings settings;
StationConfig stationConfig;

#define DHT_PIN 18
DHT_Sensor dhtSensor(DHT_PIN);

#define FlameSensor_PIN 19
Flame_Sensor FlameSensor(FlameSensor_PIN);

// Trạng thái môi trường: an toàn - false, nguy hiểm - true:
bool isDanger = false;

// Lưu thời gian hiện tại khi lấy giá trị từ các cảm biến:
unsigned long prevTimestampGetDataFromSensors = 0;

// // Lưu thời gian gửi Email:
unsigned long prevTimestampSendEmail = 0;

// Giới hạn thời gian cập nhật dữ liệu trên LCD:
unsigned long prevTimestampLCD = 0;

// Thời gian update lại cấu hình:
unsigned long prevTimeUpdate = 0;

//_____________________________________________________________________
void setup()
{
    Serial.begin(115200);

    // Lấy giá trị từ trong file settings.txt:
    initSettings();
    settings = parseConfigFile();

    // Kết nối mạng Wifi:
    connectWifi(settings.SSID, settings.Password);

    // Khởi tạo NTP Client để bắt đầu lấy thời gian thực:
    timeClient.begin();

    // Lấy đơn vị đo của cảm biến từ DB:
    getSensorUnit();

    // Khởi tạo màn hình LCD:
    setup_LCD();

    // Khởi tạo các bóng đèn leds:
    setupLeds();

    // Khởi tạo động cơ L298N:
    L298N_setup();

    // Khởi động cảm biến DHT11:
    dhtSensor.begin();
}

void loop()
{
    // Gọi hàm NTPTimerGetTime để lấy thời gian thực suốt chương trình:
    NTPTimerGetNewTime();

    // Cập nhật thời gian hiện tại của chương trình đang chạy:
    unsigned long currentTimestamp = millis();

    if (currentTimestamp - prevTimeUpdate >= 10000 || prevTimeUpdate == 0)
    {
        // Lấy ngưỡng được cấu hình của DHT từ DB để cập nhật nếu có thay đổi:
        getThresholds(settings.DHT_id);

        // Lấy thời gian hẹn giờ trên DB:
        getTimeSetter(settings.DHT_id);

        // Lấy thời gian định kỳ gửi dữ liệu:
        getTimeSendData(settings.DHT_id);

        // Lấy trạng thái động cơ:
        getMotorState(settings.DHT_id);

        // Lấy Mailer Settings:
        getMailerSettings(settings.Station_id);

        prevTimeUpdate = currentTimestamp;
    }

    // Đọc giá trị cảm biến:
    float temperature = dhtSensor.readTemperature();
    float humidity = dhtSensor.readHumidity();
    int fireSignal = FlameSensor.checkingFire();

    // Cập nhật màn hình LCD khi đến thời hạn:
    if (currentTimestamp - prevTimestampLCD >= 1000)
    {
        lcd.clear();
        setAndPrintDataLCD(0, "Temp: " + String(temperature) + "C");
        setAndPrintDataLCD(1, "Humidity: " + String(humidity) + "%");
        setAndPrintDataLCD(2, "Fire: " + String(fireSignal));

        if (isDanger)
        {
            setAndPrintDataLCD(3, "Status: Danger");
        }
        else
        {
            setAndPrintDataLCD(3, "Status: Safe");
        }

        prevTimestampLCD = currentTimestamp;
    }

    // Công việc 1:
    // - Nếu điều kiện môi trường bất thường thì khởi động động cơ và bật đèn báo nguy hiểm.
    // - Nếu điều kiện an toàn:
    //   + Kiểm tra nếu đã đến thời gian hẹn giờ: khởi động động cơ.
    //   + Nếu không thì dừng động cơ.
    //   + Bật đèn báo an toàn.
    if (temperature >= stationConfig.maxTemperature || humidity <= stationConfig.minHumidity)
    {
        LedsHighDanger();
        startEngine();
        isDanger = true;
    }
    else
    {
        if (NTPCheckTimerToDo() == true)
        {
            startEngine();
        }
        else if (stationConfig.motor_state == 1)
        {
            startEngine();
        }
        else
        {
            resetEngine();
        }

        LedsHighSafe();
        isDanger = false;
    }

    // Công việc 2: Nếu thời gian hiện tại đã đến hạn gửi data lên Database:
    // - Gửi dữ liệu lên Database
    if (currentTimestamp - prevTimestampGetDataFromSensors >= stationConfig.timeSendData || isDanger == true)
    {
        prevTimestampGetDataFromSensors = currentTimestamp;

        SendData(
            "temperature=" + String(temperature) + "&humidity=" + String(humidity) + "&fire=" + String(fireSignal) + "&dht_id=" + String(settings.DHT_id) + "&flame_id=" + String(settings.Flame_id) + "&dht_unit_temp=" + String(stationConfig.dht_unit_temp) + "&dht_unit_humid=" + String(stationConfig.dht_unit_humid) + "&flame_unit=" + String(stationConfig.flame_unit));

        if (isDanger == true)
        {
            if (currentTimestamp - prevTimestampSendEmail >= stationConfig.timeSendEmail || prevTimestampSendEmail == 0)
            {
                String mailContent = "Điều kiện môi trường đang ở mức nguy hiểm.\n";
                mailContent += "- Nhiệt độ: " + String(temperature) + "\n";
                mailContent += "- Độ ẩm: " + String(humidity) + "\n";
                mailContent += "- Lửa (0 - Có cháy / 1 - Không có cháy): " + String(fireSignal) + ".\n";
                mailContent += "\nVui lòng vào hệ thống để kiểm tra ngay!";
                
                // Khởi tạo các thành phần Mailer:
                setup_mailSession();
                setup_mailBody(mailContent);
                sendMail();

                prevTimestampSendEmail = currentTimestamp;
            }

            delay(10000); // Nếu có nguy hiểm thì 10s gửi dữ liệu 1 lần để tránh spam request
        }
    }
}
