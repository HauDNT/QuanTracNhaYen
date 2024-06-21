#ifndef EEPROM_SAVEDATA_H
#define EEPROM_SAVEDATA_H

//  Tạo kích thước cho bộ nhớ EEPROM:
#define EEPROM_SIZE 4
#define addressSave_TimeSendData 0          // Giá trị thời gian được lưu trong EEPROM là ở mili giây 
                                            // nên khi gán vào timeSendData phải nhân thêm 1000
                                            // Do phạm vi đọc dữ liệu của EEPROM chỉ nằm trong 1 byte (0 -> 255)
#define addressSave_TemperatureWarning 1
#define addressSave_HumidWarning_Low 2
#define addressSave_HumidWarning_High 3

extern int timeSendData;
extern float temperatureWarning;
extern float humidWarning_LOW;
extern float humidWarning_HIGH;

// Lấy giá trị từ EEPROM:
void getValuesEEPROM() {
  timeSendData = EEPROM.read(addressSave_TimeSendData) * 1000;          // Chu kỳ gửi dữ liệu
  temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);     // Nhiệt độ ngưỡng
  humidWarning_LOW = EEPROM.read(addressSave_HumidWarning_Low);                 // Độ ẩm ngưỡng thấp nhất
  humidWarning_HIGH = EEPROM.read(addressSave_HumidWarning_High);               // độ ẩm ngưỡng cao nhất
}

void setupEEPROM() {
    EEPROM.begin(EEPROM_SIZE);

    timeSendData = EEPROM.read(addressSave_TimeSendData);
    humidWarning_LOW = EEPROM.read(addressSave_HumidWarning_Low);
    humidWarning_HIGH = EEPROM.read(addressSave_HumidWarning_High);
    temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);

    // Nếu giá trị chưa được gán ( = 255 = 0xFF)
    if (timeSendData == 0xFF || temperatureWarning == 0xFF) {
        EEPROM.write(addressSave_TemperatureWarning, 35);
        EEPROM.write(addressSave_HumidWarning_Low, 70);
        EEPROM.write(addressSave_HumidWarning_High, 80);
        EEPROM.write(addressSave_TimeSendData, 2);
        EEPROM.commit();
    }

    getValuesEEPROM();
}

void updateValues(int newTime, float newTemp, float newHumid_Low, float newHumid_High) {
    // Ghi lại giá trị thời gian (ở mili giây) & nhiệt độ & độ ẩm:
    EEPROM.write(addressSave_TimeSendData, newTime);
    EEPROM.write(addressSave_TemperatureWarning, (int) newTemp);    // Chuyển giá trị nhiệt độ thành số nguyên để lưu vào bộ nhớ
    EEPROM.write(addressSave_HumidWarning_Low, (int) newHumid_Low);         // Chuyển giá trị độ ẩm thành số nguyên để lưu vào bộ nhớ
    EEPROM.write(addressSave_HumidWarning_High, (int) newHumid_High);
    EEPROM.commit();

    // Đọc lại giá trị:
    getValuesEEPROM();
}

#endif
