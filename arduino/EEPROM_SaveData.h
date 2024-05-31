#ifndef EEPROM_SAVEDATA_H
#define EEPROM_SAVEDATA_H

//  Tạo kích thước cho bộ nhớ EEPROM:
#define EEPROM_SIZE 3
#define addressSave_TimeSendData 0          // Giá trị thời gian được lưu trong EEPROM là ở mili giây 
                                            // nên khi gán vào timeSendData phải nhân thêm 1000
                                            // Do phạm vi đọc dữ liệu của EEPROM chỉ nằm trong 1 byte (0 -> 255)
#define addressSave_TemperatureWarning 1
#define addressSave_HumidWarning 2

extern int timeSendData;
extern float temperatureWarning;
extern float humidWarning;

// Lấy giá trị từ EEPROM:
void getValuesEEPROM() {
  temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);     // Nhiệt độ ngưỡng
  humidWarning = EEPROM.read(addressSave_HumidWarning);                 // Độ ẩm ngưỡng
  timeSendData = EEPROM.read(addressSave_TimeSendData) * 1000;          // Chu kỳ gửi dữ liệu
}

void setupEEPROM() {
    EEPROM.begin(EEPROM_SIZE);

    timeSendData = EEPROM.read(addressSave_TimeSendData);
    humidWarning = EEPROM.read(addressSave_HumidWarning);
    temperatureWarning = EEPROM.read(addressSave_TemperatureWarning);

    // Nếu giá trị chưa được gán ( = 255 = 0xFF)
    if (timeSendData == 0xFF || temperatureWarning == 0xFF) {
        EEPROM.write(addressSave_TemperatureWarning, 35);
        EEPROM.write(addressSave_HumidWarning, 70);
        EEPROM.write(addressSave_TimeSendData, 2);
        EEPROM.commit();
    }

    getValuesEEPROM();
}

void updateValues(int newTime, float newTemp, float newHumid) {
    // Ghi lại giá trị thời gian (ở mili giây) & nhiệt độ & độ ẩm:
    EEPROM.write(addressSave_TimeSendData, newTime);
    EEPROM.write(addressSave_TemperatureWarning, (int) newTemp);    // Chuyển giá trị nhiệt độ thành số nguyên để lưu vào bộ nhớ
    EEPROM.write(addressSave_HumidWarning, (int) newHumid);         // Chuyển giá trị độ ẩm thành số nguyên để lưu vào bộ nhớ
    EEPROM.commit();

    // Đọc lại giá trị:
    getValuesEEPROM();
}

#endif
