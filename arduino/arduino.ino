#include "DHT_Sensor.h"
#include "Flame_Sensor.h"
#include "L298N.h"
#include "LedStatus.h"
#include "ConnectWifi.h"
#include "SendData.h"
#include <WebServer.h>
#include "WebServer.h"
#include "DDNS.h"
#include <EEPROM.h>
#include "EEPROM_SaveData.h"

//---------------------------------------------------------Khai báo---------------------------------------------------------
#define DHT_1_PIN 18
DHT_Sensor dhtSensor_1(DHT_1_PIN);

#define FlameSensor_1_PIN 19
Flame_Sensor FlameSensor_1(FlameSensor_1_PIN);

// Mã id của các cảm biến trong tầng chiếu theo DB (VD 1 tầng 1 bộ gồm: 1 DHT 11, 1 FlameSensor)
const int dht11_id = 1;
const int flame_id = 2;

// Trạng thái môi trường: an toàn - false, nguy hiểm - true:
bool isDanger = false;

// Các tham số sẽ được cập nhật thông qua ESP32 Server:
WebServer server(80);
int timeSendData;     // Chu kỳ gửi dữ liệu 
float temperatureWarning; // Nhiệt độ cảnh báo

// Thời gian cập nhật mới DDNS:
unsigned long previousTimeUpdateDDNS = 0; // Lưu thời điểm hiện tại khi update lại DDNS
const long timeRenderDDNS = 600000;       // 10 phút cập nhật 1 lần

// Lưu thời gian hiện tại khi lấy giá trị từ các cảm biến:
unsigned long prevTimestampGetDataFromSensors = 0;

//---------------------------------------------------------Chương trình---------------------------------------------------------
void setup()
{
  // Connect wifi:
  connectWifi();

  // Start DDNS:
  updateDDNS();

  // Start ESP32 Server:
  StartServer();

  // Setup leds:
  setupLeds();

  // Setup L298N:
  L298N_setup();

  // Setup EEPROM để lưu cấu hình và khởi tạo giá trị ban đầu:
  setupEEPROM();

  // DHT11 starts:
  dhtSensor_1.begin();

  Serial.begin(115200);
}

void loop()
{
  unsigned long currentTimestamp = millis();

  // Show thông tin kết nối Wifi:
  ConnectWFData();

  // Nhận tương tác từ phía người dùng trên Server:
  server.handleClient();

  // Đọc giá trị cảm biến:
  float temperatureDHT11 = dhtSensor_1.readTemperature();
  float humidity = dhtSensor_1.readHumidity();
  int fireSignal = FlameSensor_1.checkingFire();

  // Công việc 1 - Kiểm tra điều kiện môi trường và khởi động/dừng động cơ:
  // Kiểm tra nhiệt độ:
  if (temperatureDHT11 > temperatureWarning)
  {
      // Nếu nhiệt độ đạt đến mức nguy hiểm và hiện không có lửa:
      LedsHighDanger(); // Đèn báo nguy hiểm
      startEngine();    // Cho động cơ L298N chuyển động
      isDanger = true;  // Trạng thái môi trường được đặt ở mức nguy hiểm
  }
  else
  {
      // Nếu nhiệt độ ở mức an toàn:
      LedsHighSafe(); // Đèn báo an toàn
      resetEngine();  // Cho động cơ L298N ngừng lại
      isDanger = false;  // Trạng thái môi trường được đặt ở mức an toàn
  }

  // Công việc 2 - Gửi dữ liệu và kiểm tra môi trường:
  // Nếu thời gian hiện tại đã vượt hoặc bằng thời hạn gửi data - Hoặc môi trường có nguy hiểm thì gửi ngay dữ liệu:
  if (currentTimestamp - prevTimestampGetDataFromSensors >= timeSendData || isDanger == true)
  {
    prevTimestampGetDataFromSensors = currentTimestamp;

    // ESP32 sends data:
    SendData(
        "temperature=" + String(temperatureDHT11) +
        "&humidity=" + String(humidity) +
        "&fire=" + String(fireSignal));

    if (isDanger == true) delay(10000);   // Nếu có nguy hiểm thì 10s gửi dữ liệu 1 lần để tránh spam request
  }

  // Re-render DDNS:
  if (currentTimestamp - previousTimeUpdateDDNS >= timeRenderDDNS)
  {
    previousTimeUpdateDDNS = currentTimestamp;
    updateDDNS();
  }
}
