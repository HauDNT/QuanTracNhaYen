#ifndef SEND_DATA_H
#define SEND_DATA_H

// Website cần gửi thông tin đến
const char *URL = "http://192.168.225.67/nhayen/modules/insertValuesSensor.php";

void SendData(String data)
{
  HTTPClient http;
  http.begin(URL);
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
