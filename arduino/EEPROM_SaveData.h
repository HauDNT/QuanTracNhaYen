#ifndef EEPROM_SAVEDATA_H
#define EEPROM_SAVEDATA_H

#include <EEPROM.h>

//  Tạo kích thước cho bộ nhớ EEPROM:
#define EEPROM_SIZE 2
#define addressSave_TimeSendData 0          // Giá trị thời gian được lưu trong EEPROM là ở mili giây 
                                            // nên khi gán vào timeSendData phải nhân thêm 1000
                                            // Do phạm vi đọc dữ liệu của EEPROM chỉ nằm trong 1 byte (0 -> 255)
#define addressSave_TemperatureWarning 1

extern int timeSendData;
extern float temperatureWarning;

// Lấy giá trị từ EEPROM:
void getValuesEEPROM() {
  temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);
  Serial.print("=> Nhiệt độ ngưỡng: ");
  Serial.println(temperatureWarning);
  
  timeSendData = EEPROM.read(addressSave_TimeSendData) * 1000;
  Serial.print("=> Chu kỳ gửi dữ liệu: ");
  Serial.println(timeSendData);
}

void setupEEPROM() {
    EEPROM.begin(EEPROM_SIZE);

    timeSendData = EEPROM.read(addressSave_TimeSendData);
    temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);

    // Nếu giá trị chưa được gán ( = 255 = 0xFF)
    if (timeSendData == 0xFF || temperatureWarning == 0xFF) {
        EEPROM.write(addressSave_TimeSendData, 2);
        EEPROM.write(addressSave_TemperatureWarning, 35);
        EEPROM.commit();
    }

    getValuesEEPROM();
}

void updateValues(int newTime, float newTemp) {
    // Ghi lại giá trị thời gian (ở mili giây) & nhiệt độ:
    EEPROM.write(addressSave_TimeSendData, newTime);
    EEPROM.write(addressSave_TemperatureWarning, (int)newTemp); // Chuyển giá trị nhiệt độ thành số nguyên để lưu vào bộ nhớ
    EEPROM.commit();

    // Đọc lại giá trị:
    getValuesEEPROM();
}

#endif
