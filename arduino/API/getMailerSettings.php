<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "environment_control_system";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy ngưỡng cảnh báo của cảm biến DHT:
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['station_id'])) {
        $station_id = $_GET['station_id'];

        $sql = "SELECT e.sender_name, e.sender_email, e.sender_password, u.email AS recipient_email , u.fullname AS recipient_name, e.timeSendEmail
                FROM email_settings e
                JOIN stations s ON s.id = e.station_id
                JOIN userinfo u ON u.account_id = s.user_id
                WHERE s.id = '$station_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No data found."));
        }
    } else {
        echo json_encode(array("error" => "No data found."));
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
