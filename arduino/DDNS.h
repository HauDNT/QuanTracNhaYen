#ifndef DDNS
#define DDNS

#include <WiFi.h>
#include <HTTPClient.h>

// DDNS của trạm 1:
//const char* ddns_hostname = "esp32webserver.ddns.net";
//const char* ddns_username = "hau21072006018@vnkgu.edu.vn";
//const char* ddns_password = "hau21072006018@vnkgu.edu.vn";

// DDNS của trạm 2:
const char* ddns_hostname = "esp32webserver2.ddns.net";
const char* ddns_username = "tienhau.it@gmail.com";
const char* ddns_password = "tienhau.it@gmail.com";

// URL cập nhật No-IP
const char* update_url = "http://dynupdate.no-ip.com/nic/update";

void updateDDNS() {
  HTTPClient http;
  String url = String(update_url) + "?hostname=" + ddns_hostname;
  
  http.begin(url);
  http.setAuthorization(ddns_username, ddns_password);

  int httpCode = http.GET();

  Serial.println("----------------- DDNS updating... -----------------");
  if (httpCode > 0) {
    String payload = http.getString();
    Serial.println("HTTP Response code: " + String(httpCode));
    Serial.println("Response: " + payload);
  } else {
    Serial.println("Error on HTTP request: " + http.errorToString(httpCode));
  }

  http.end();

}

#endif
