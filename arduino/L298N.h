#ifndef L298N_H
#define L298N_H

// Khai báo chân các động cơ L298N
int engine_PIN1 = 27;
int engine_PIN2 = 26;
int enable_PIN = 14;

// Thuộc tính kiểm soát tốc độ của L298N:
const int freq = 30000;   // Tín hiệu 30000hz
const int pwnChannel = 0; // Kênh số 0
const int resolution = 8; // Độ phân giải 8 bit
int dutyCycle = 200;      // Bắt đầu chu kỳ nhiệm vụ: 200 (Có khả năng nếu nhỏ hơn 200 thì động cơ không hoạt động được - phụ thuộc vào tần số động cơ)

// Thời gian quay của động cơ:
unsigned long engineStartDuration = 5000;
// Thời gian hiện tại động cơ đang hoạt động:
unsigned long previousEngineMillis = 0;
// Trạng thái của động cơ (chạy/không chạy):
bool engineRun = false;

// Hàm setup thiết lập L298N:
void L298N_setup()
{
    // Thiết lập các chân L298N:
    pinMode(engine_PIN1, OUTPUT);
    pinMode(engine_PIN2, OUTPUT);
    pinMode(enable_PIN, OUTPUT);

    // Định cấu hình tín hiệu PWM:
    ledcSetup(pwnChannel, freq, resolution);

    // Thiết lập chân GPIO sẽ nhận tín hiệu:
    ledcAttachPin(enable_PIN, pwnChannel);

    // Thiết lập chu kỳ nhiệm vụ ban đầu cho kênh PWM:
    ledcWrite(pwnChannel, dutyCycle);
};

// Hàm khởi động động cơ:
void startEngine()
{
    engineRun = true;                // Set động cơ đang chạy (true)
    previousEngineMillis = millis(); // Lưu thời điểm hiện tại vào previousEngineMillis

    digitalWrite(engine_PIN1, HIGH);
    digitalWrite(engine_PIN2, LOW);
    Serial.println("-> Quạt tản nhiệt đang chạy...\n");
};

// Hàm kiểm tra: nếu động cơ chạy vượt quá thời gian thì dừng lại
void resetEngine()
{
    if (engineRun // Nếu động cơ đang chạy
        &&
        (millis() - previousEngineMillis >= engineStartDuration)) // Vượt quá thời gian giới hạn

    engineRun = false;
    digitalWrite(engine_PIN1, LOW);
    digitalWrite(engine_PIN2, LOW);
    Serial.println("-> Quạt tản nhiệt dừng chạy...\n");
}

#endif
