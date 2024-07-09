#ifndef ESP_MAILER_H
#define ESP_MAILER_H

#include "ConnectWifi.h"
#include "GetConfigStation.h"

extern StationConfig stationConfig;

// Các biến dùng cho việc gửi mail:
#define SMTP_server "smtp.gmail.com"
#define SMTP_Port 465

SMTPSession smtp;
ESP_Mail_Session session;
SMTP_Message message;

void setup_mailSession()
{
    Serial.println("Setup mail session");

    smtp.debug(1);

    session.server.host_name = SMTP_server;
    session.server.port = SMTP_Port;

    session.login.email = stationConfig.sender_email;
    session.login.password = stationConfig.sender_password;

    session.login.user_domain = "";
}

void setup_mailBody(String content) 
{
    message.sender.name = stationConfig.sender_name;
    message.sender.email = stationConfig.sender_email;

    String mail_subject = "Email cảnh báo môi trường nguy hiểm từ trạm: " + String(stationConfig.sender_name);

    message.subject = mail_subject.c_str();
    message.addRecipient(stationConfig.recipient_name, stationConfig.recipient_email);

    message.text.content = content;
    message.text.charSet = "us-ascii";
    message.text.transfer_encoding = Content_Transfer_Encoding::enc_7bit;
}


void sendMail()
{
    if (!smtp.connect(&session)) {
        Serial.println("Kết nối đến mail server thất bại!");
        return;
    }

    if (!MailClient.sendMail(&smtp, &message))
    {
        Serial.println("Đã xảy ra lỗi khi gửi mail, " + smtp.errorReason());
    }
    else
    {
        Serial.println("Mail đã được gửi thành công!");
    }

    smtp.closeSession();
}

#endif