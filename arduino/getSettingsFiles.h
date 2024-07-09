#ifndef GET_SETTINGS_FILES_H
#define GET_SETTINGS_FILES_H

struct Settings
{
    String DHT_id;
    String Flame_id;
    int Station_id;
    String SSID;
    String Password;
    String Server_IP;
};

extern Settings settings;

Settings parseConfigFile();

Settings parseConfigFile()
{
    Settings config = {"", "", 0, "", "", ""};

    if (!SPIFFS.begin(true))
    {
        Serial.println("Failed to mount file system");
        return config;
    }

    File file = SPIFFS.open("/settings.txt", FILE_READ);
    if (!file)
    {
        Serial.println("Failed to open file for reading");
        return config;
    }

    while (file.available())
    {
        String line = file.readStringUntil('\n');
        line.trim();

        int separatorIndex = line.indexOf('=');
        if (separatorIndex == -1)
        {
            continue;
        }

        String key = line.substring(0, separatorIndex);
        String value = line.substring(separatorIndex + 1);
        value.trim();

        if (key == "dht_id")
        {
            config.DHT_id = value.c_str();
        }
        else if (key == "flame_id")
        {
            config.Flame_id = value.c_str();
        }
        else if (key == "station_id")
        {
            config.Station_id = value.toInt();
        }
        else if (key == "ssid")
        {
            config.SSID = value.c_str();
        }
        else if (key == "password")
        {
            config.Password = value.c_str();
        }
        else if (key == "server_ip")
        {
            config.Server_IP = value.c_str();
        }
    }

    file.close();
    return config;
}

void initSettings()
{
    // Tạo file settings.txt với nội dung mẫu nếu chưa tồn tại
    if (!SPIFFS.exists("/settings.txt"))
    {
        File file = SPIFFS.open("/settings.txt", FILE_WRITE);
        if (file)
        {
            file.println("dht_id: SS2024XXXXX");
            file.println("flame_id: SS2024XXXXX");
            file.println("station_id: 0");
            file.close();
        }
    }
}

#endif
