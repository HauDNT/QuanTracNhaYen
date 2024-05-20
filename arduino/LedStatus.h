#ifndef LED_STATUS_H
#define LED_STATUS_H

// Khai báo hai chân led tín hiệu:
int ledSafe = 2;
int ledDanger = 4;

// Setup leds:
void setupLeds() {
    pinMode(ledSafe, OUTPUT);
    pinMode(ledDanger, OUTPUT);
};

// Hàm show led khi nguy hiểm
void LedsHighDanger() {
    digitalWrite(ledSafe, 0);       // Cho đèn báo an toàn bật
    digitalWrite(ledDanger, 1);     // Cho đèn báo nguy hiểm tắt
}

// Hàm show led khi an toàn
void LedsHighSafe() {
    digitalWrite(ledSafe, 1);       // Cho đèn báo an toàn tắt
    digitalWrite(ledDanger, 0);     // Cho đèn báo nguy hiểm bật
}

#endif
