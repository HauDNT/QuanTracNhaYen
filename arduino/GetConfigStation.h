#ifndef THRESHOLD_CONFIG_H
#define THRESHOLD_CONFIG_H

#include "getSettingsFiles.h"

extern Settings settings;

struct StationConfig
{
    int timeSendData;
    
    // Thresholds:
    float minTemperature;
    float maxTemperature;
    float minHumidity;
    float maxHumidity;

    // Units:
    int dht_unit_temp;
    int dht_unit_humid;
    int flame_unit;

    // Time setter:
    int start_hour;
    int start_minute;
    int stop_hour;
    int stop_minute;

    // Motor control:
    int motor_state;

    // Mailer settings:
    String sender_name;
    String sender_email;
    String sender_password;
    String recipient_email;
    String recipient_name;
    int timeSendEmail;

    // Wifi settings:
    String ssid;
    String password;
};

extern StationConfig stationConfig;

HTTPClient http;

// Hàm lấy ngưỡng cảnh báo từ server
void getThresholds(String sensor_id)
{
    String url = "http://" + settings.Server_IP + "/arduino/API/getThresholdDHT.php" + "?sensor_id=" + sensor_id;
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.minTemperature = doc["temp_thres_min"];
        stationConfig.maxTemperature = doc["temp_thres_max"];
        stationConfig.minHumidity = doc["humid_thres_min"];
        stationConfig.maxHumidity = doc["humid_thres_max"];
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy mã đơn vị "nhiệt độ"
void getDHTUnitTemp()
{
    String url = "http://" + settings.Server_I/arduino/API/getUnitSensor.php" + "?temp";
    Serial.println(url);

    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.dht_unit_temp = doc["temp_unit_id"];
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy mã đơn vị "độ ẩm"
void getDHTUnitHumid()
{
    String url = "http://" + settings.Server_I/arduino/API/getUnitSensor.php" + "?humid";
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.dht_unit_humid = doc["humid_unit_id"];
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy mã đơn vị "lửa"
void getUnitFire()
{
    String url = "http://" + settings.Server_I/arduino/API/getUnitSensor.php" + "?fire";
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.flame_unit = doc["fire_unit_id"];
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy tất cả mã đơn vị
void getSensorUnit()
{
    getDHTUnitTemp();
    getDHTUnitHumid();
    getUnitFire();
}

// Hàm lấy thời gian hẹn giờ
void getTimeSetter(String sensor_id)
{
    String url = "http://" + settings.Server_I/arduino/API/getTimeSetter.php" + "?sensor_id=" + sensor_id;
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        String time_start = doc["time_start"];
        String time_finish = doc["time_finish"];

        // Tách giờ và phút từ time_start
        int start_hour = time_start.substring(0, 2).toInt();
        int start_minute = time_start.substring(3, 5).toInt();

        // Tách giờ và phút từ time_finish
        int stop_hour = time_finish.substring(0, 2).toInt();
        int stop_minute = time_finish.substring(3, 5).toInt();

        stationConfig.start_hour = start_hour;
        stationConfig.start_minute = start_minute;
        stationConfig.stop_hour = stop_hour;
        stationConfig.stop_minute = stop_minute;
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy thời gian định kỳ gửi dữ liệu:
void getTimeSendData(String sensor_id)
{
    String url = "http://" + settings.Server_I/arduino/API/getTimeSendData.php" + "?sensor_id=" + sensor_id;
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.timeSendData = doc["time_send_data"].as<int>() * 60000;
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy trạng thái động cơ trên DB:
void getMotorState(String sensor_id)
{
    String url = "http://" + settings.Server_I/arduino/API/getMotorState.php" + "?sensor_id=" + sensor_id;
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        stationConfig.motor_state = doc["motor_status"];
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

// Hàm lấy thông tin thiết lập Mailer:
void getMailerSettings(int station_id)
{
    String url = "http://" + settings.Server_I/arduino/API/getMailerSettings.php" + "?station_id=" + station_id;
    http.begin(url);
    int httpCode = http.GET();

    if (httpCode > 0)
    {
        String payload = http.getString();
        Serial.println(payload);

        DynamicJsonDocument doc(1024);
        DeserializationError error = deserializeJson(doc, payload);

        if (error)
        {
            Serial.print(F("deserializeJson() failed: "));
            Serial.println(error.c_str());
            return;
        }

        if (doc.containsKey("sender_name") && doc.containsKey("sender_email") && doc.containsKey("sender_password") &&
            doc.containsKey("recipient_email") && doc.containsKey("recipient_name") && doc.containsKey("timeSendEmail"))
        {
            stationConfig.sender_name = String(doc["sender_name"].as<const char *>());
            stationConfig.sender_email = String(doc["sender_email"].as<const char *>());
            stationConfig.sender_password = String(doc["sender_password"].as<const char *>());
            stationConfig.recipient_email = String(doc["recipient_email"].as<const char *>());
            stationConfig.recipient_name = String(doc["recipient_name"].as<const char *>());
            stationConfig.timeSendEmail = doc["timeSendEmail"].as<int>() * 60000;
        }
        else
        {
            Serial.println("JSON payload is missing some keys.");
        }
    }
    else
    {
        Serial.println("Error on HTTP request");
    }

    http.end();
}

#endif
