<?php
    include '../config/database.php';
    include '../libraries/database.php';

    // Kết nối tới cơ sở dữ liệu
    db_connect($db);

    if (
        isset($_POST["temperature"]) &&
        isset($_POST["humidity"]) &&
        isset($_POST["fire"]) &&
        isset($_POST["dht_id"]) &&
        isset($_POST["flame_id"])
    ) {
        $temperature = $_POST["temperature"];
        $humidity = $_POST["humidity"];
        $fire = $_POST["fire"];
        $dht_id = $_POST["dht_id"];
        $flame_id = $_POST["flame_id"];

        // Insert  
        $sql = "INSERT INTO sensor_values (sensor_id, value, unit_id) VALUES 
                    ($dht_id, " . $humidity . ", 1),
                    ($dht_id, " . $temperature . ", 3),
                    ($flame_id, " . $fire . ", 2)";

        if (mysqli_query($conn, $sql)) {
            echo "Thêm dữ liệu cảm biến thành công!";
        } else {
            echo "Thêm dữ liệu cảm biến không thành công!";
        }
    }

    // Đóng kết nối
    mysqli_close($conn);