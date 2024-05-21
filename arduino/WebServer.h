#ifndef WEB_SERVER_H
#define WEB_SERVER_H

#include <WiFi.h>
#include <WebServer.h>
#include <ArduinoJson.h>
#include <SPIFFS.h>
#include "EEPROM_SaveData.h"

// Tạo Webserver cho ESP32 để lắng nghe sự thay đổi:
extern WebServer server;
extern int timeSendData;
extern float temperatureWarning;

// ----- Tạo trang Webserver ESP32
void Create_HTMLPage()
{
  // Khởi tạo HTML Webserver page:
  File file = SPIFFS.open("/index.html", "r");
  if (!file)
  {
    server.send(404, "text/plain", "File not found!");
    return;
  }

  // Đọc file HTML và thay thế các giá trị hiện tại vào trong các ô input:
  String page = file.readString();
  page.replace("{{interval}}", String(timeSendData / 1000));
  page.replace("{{temperature}}", String(temperatureWarning));
  server.send(200, "text/html", page);
  file.close();
};

void Create_CSSPage()
{
  // Khởi tạo CSS HTML Webserver page:
  File file = SPIFFS.open("/style.css", "r");
  if (!file)
  {
    server.send(404, "text/plain", "File not found!");
    return;
  }

  String css = file.readString();
  server.send(200, "text/css", css);
  file.close();
};

void UpdateParams()
{
  // Cập nhật sau khi được ấn nút "Cập nhật" thì dữ liệu sẽ được gửi đến URL /update-settings
  // Hàm UpdateParams() này sẽ thực thi mọi tác vụ sau:

  // Nếu có yêu cầu thay đổi về interval (thời gian gửi dữ liệu) và nhiệt độ nguy hiểm:
  if (server.hasArg("interval") && server.hasArg("temperature"))
  {
    // Lấy giá trị này và cập nhật vào board ESP32:
    String getInterval = server.arg("interval");
    String getTemp = server.arg("temperature");

    Serial.print("Received interval: ");
    Serial.println(getInterval);
    Serial.print("Received temperature: ");
    Serial.println(getTemp);

    // Sau đó đưa giá trị này vào cập nhật trong EEPROM để nó vẫn còn dù ESP32 mất nguồn:
    updateValues(
      getInterval.toInt(),  // ms
      getTemp.toFloat()
    );
    // Chuyển đổi chuỗi ký tự thành giá trị unsigned long

    // Sau khi gửi đến đường dẫn /update-settings thì điều hướng lại về trang chính
    String message = "<script>alert('Settings Updated'); window.location.href = \"/\";</script>";

    server.send(200, "text/html", message);
  }
  else
  {
    String message = "<script>alert('Invalid Request'); window.location.href = \"/\";</script>";
    server.send(400, "text/html", message);
  }
};

void StartServer()
{
  // Khởi động SPIFFS
  if (!SPIFFS.begin(true))
  {
    Serial.println("An error has occurred while mounting SPIFFS");
    return;
  }

  server.on("/", HTTP_GET, Create_HTMLPage);
  server.on("/style.css", HTTP_GET, Create_CSSPage);
  server.on("/update-settings", HTTP_POST, UpdateParams);
  server.begin();
};

#endif
