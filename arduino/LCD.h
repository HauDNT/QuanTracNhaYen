#ifndef LCD_H
#define LCD_H

LiquidCrystal_I2C lcd(0x27, 20, 4);  

void setup_LCD()
{
    // Khởi tạo màn hình LCD
    lcd.init();

    // Bật đèn nền
    lcd.backlight();
}

void setAndPrintDataLCD(int row, const String& data)
{
    lcd.setCursor(0, row);
    lcd.print(data);
} 

#endif