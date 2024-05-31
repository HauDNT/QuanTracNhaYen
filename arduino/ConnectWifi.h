#ifndef CONNECT_WIFI_H
#define CONNECT_WIFI_H

const char *ssid = "Wifi";
const char *password = "tienhau2003@";

void connectWifi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);

  WiFi.mode(WIFI_STA);

  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED)
  {
    delay(500);
    Serial.print(".");
  }

  Serial.print("Connected to " + String(ssid) + " success!");
};

void ConnectWFData() {
    Serial.print("Connected to: ");
    Serial.println(ssid);
    Serial.print("ESP32's IP address: ");
    Serial.println(WiFi.localIP());
}

#endif
