#ifndef DHT_SENSOR_H
#define DHT_SENSOR_H

#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>

class DHT_Sensor {
private:
    int PIN;
    DHT dht;

public:
    DHT_Sensor(int DHT_PIN);
    void begin();
    float readTemperature();
    float readHumidity();
    void showData(float temperature, float humidity);
};

#endif
