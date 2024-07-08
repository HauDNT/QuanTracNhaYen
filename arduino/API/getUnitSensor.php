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

// Lấy các đơn vị đo cảm biến:
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['temp'])) {
        $sql = "SELECT id AS temp_unit_id FROM indicators WHERE name = 'Nhiệt độ'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No data found."));
        }
    }
    else if (isset($_GET['humid'])) {
        $sql = "SELECT id AS humid_unit_id FROM indicators WHERE name = 'Độ ẩm'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No data found."));
        }
    }
    else if (isset($_GET['fire'])) {
        $sql = "SELECT id AS fire_unit_id FROM indicators WHERE name = 'Lửa'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No data found."));
        }
    }else {
        echo json_encode(array("error" => "No data found."));
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
