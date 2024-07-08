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

        $sql = "SELECT temp_thres_min, temp_thres_max, humid_thres_min, humid_thres_max 
                FROM station_settings 
                WHERE station_id='$station_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No data found."));
        }
    }
    else {
        echo json_encode(array("error" => "No data found."));
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
