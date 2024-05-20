#ifndef WEB_SERVER_H
#define WEB_SERVER_H

#include <WiFi.h>
#include <WebServer.h>
#include <ArduinoJson.h>
#include <SPIFFS.h>

// Tạo Webserver cho ESP32 để lắng nghe sự thay đổi:
extern WebServer server;
extern unsigned long timeSendData;
extern unsigned long temperatureWarning;

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
  if (server.hasArg("interval") && server.hasArg("temperature"))
  {
    String getInterval = server.arg("interval");
    String getTemp = server.arg("temperature");

    timeSendData = getInterval.toInt() * 1000; // Nhân cho 1000 vì Arduino chỉ dùng miliseconds
    temperatureWarning = getTemp.toFloat();       // Cập nhật giá trị nhiệt độ

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
