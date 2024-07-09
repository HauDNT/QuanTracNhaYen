#ifndef SEND_DATA_H
#define SEND_DATA_H

#include "getSettingsFiles.h"

extern Settings settings;

void SendData(String data)
{
  // URL Server cần gửi thông tin đến
  String URL = "http://" + settings.Server_IP + "/?mod=monitoring&action=addValue";
  
  HTTPClient http;
  http.begin(URL.c_str());
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(data);
  String payload = http.getString();

  Serial.print("URL: ");
  Serial.println(URL);
  Serial.print("Data: ");
  Serial.println(data);
  Serial.print("httpCode: ");
  Serial.println(httpCode);
  Serial.print("payload: ");
  Serial.println(payload);
};

#endif
