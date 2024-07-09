#ifndef SET_TIMER_H
#define SET_TIMER_H

#include "GetConfigStation.h"

extern StationConfig stationConfig;

// Khởi tạo NTP Client để nhận thời gian:
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP, "pool.ntp.org", 7 * 3600); // Độ lệch múi giờ

// Biến thời gian hiện tại
int currentHour;
int currentMinute;
int currentSecond;

// Hàm cập nhật thời gian thực từ NTP Client
void NTPTimerGetNewTime()
{
    // Cập nhật thời gian thực vào NTP Client sau mỗi lần lặp của chương trình:
    timeClient.update();

    currentHour = timeClient.getHours();
    currentMinute = timeClient.getMinutes();
    currentSecond = timeClient.getSeconds();
}

// Hàm kiểm tra khoảng thời gian [bắt đầu, kết thúc]
bool NTPCheckTimerToDo()
{
    // Nếu thời gian hiện tại vẫn nằm trong khoảng thời gian [bắt đầu, kết thúc] thì cho phép
    // thực hiện 1 việc nào đó (return true)
    if ((currentHour > stationConfig.start_hour || (currentHour == stationConfig.start_hour && currentMinute >= stationConfig.start_minute)) &&
        (currentHour < stationConfig.stop_hour || (currentHour == stationConfig.stop_hour && currentMinute < stationConfig.stop_minute)))
    {
        return true;
    }
    else
    {
        return false;
    }
}

#endif