<?php
function construct()
{
    load_model('index');
}

function indexAction()
{
    // Lấy danh sách các trạm trong DB:
    $list_station_info = get_list_station_info();
    // Lấy danh sách users infor để thêm vào quản lý trạm:
    $list_user_info = get_list_user_info();

    $data = array(
        'active' => 'stations',
        'list_station_info' => $list_station_info,
        'list_user_info' => $list_user_info,
    );

    load_view('index', $data);
}

function addStationAction()
{
    if (isset($_POST['add_station'])) {
        if (
            empty($_POST['station_name']) ||
            empty($_POST['station_longtitude']) ||
            empty($_POST['station_langtitude']) ||
            empty($_POST['station_urlServer']) ||
            empty($_POST['station_detail']) ||
            empty($_POST['station_user'])
        ) {
            $_SESSION['error'] = "<b>THÊM THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        } else {
            $station_name = $_POST['station_name'];
            $station_longtitude = $_POST['station_longtitude'];
            $station_langtitude = $_POST['station_langtitude'];
            $station_urlServer = $_POST['station_urlServer'];
            $station_detail = $_POST['station_detail'];
            $station_user = $_POST['station_user'];
        }

        if (empty($_SESSION['error'])) {
            $data_stations = array(
                'name' => $station_name,
                'longtitude' => $station_longtitude,
                'langtitude' => $station_langtitude,
                'urlServer' => $station_urlServer,
                'detail' => $station_detail,
                'user_id' => $station_user,
            );

            db_insert('stations', $data_stations);

            $_SESSION['success'] = 'Thêm trạm mới <b>THÀNH CÔNG!</b>';
        }
    }
    header('location: ?mod=stations');
}

function addSensorToStationAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['sensorId']) || empty($_POST['stationId'])) {
            echo "Thêm cảm biến thất bại!";
        } else {
            $sensorId = (int) $_POST['sensorId'];
            $stationId = (int) $_POST['stationId'];

            $insert = "INSERT INTO station_sensors(station_id, sensor_id) VALUES('{$stationId}', '{$sensorId}')";
            db_query($insert);

            db_update('sensors', ["connect_status" => 1], 'id=' . $sensorId);

            echo "Thêm cảm biến thành công!";
        }
    } else echo "Thêm cảm biến thất bại!";
}

function deleteSensorFromStationAction()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['sensorId']) || empty($_POST['stationId'])) {
            echo "Xóa cảm biến thất bại!";
        } else {
            $sensorId = (int) $_POST['sensorId'];
            $stationId = (int) $_POST['stationId'];

            $query = "SELECT * FROM station_sensors WHERE sensor_id = '{$sensorId}' AND station_id = '{$stationId}'";
            $num_rows = mysqli_num_rows(db_query($query));

            if ($num_rows > 0) {
                $delete = "DELETE FROM station_sensors WHERE sensor_id = '{$sensorId}' AND station_id = '{$stationId}'";
                db_query($delete);
    
                db_update('sensors', ["connect_status" => 0], 'id=' . $sensorId);
    
                http_response_code(200);
                echo "Xóa cảm biến thành công!";
            }
            else {
                http_response_code(404);
                echo "Không thể xóa cảm biến của trạm khác!";
            }
        }
    } else echo "Xóa cảm biến thất bại!";
}

function updateStationAction()
{
    if (isset($_POST['update_station'])) {
        $id = (int) $_GET['id'];
        show_array($id);

        if (empty($_POST['station_name'] ||
            $_POST['station_longtitude'] ||
            $_POST['station_langtitude'] ||
            $_POST['station_urlServer'] ||
            $_POST['station_detail'] ||
            $_POST['station_user'])) {
            $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        } else {
            $station_name = $_POST['station_name'];
            $station_longtitude = $_POST['station_longtitude'];
            $station_langtitude = $_POST['station_langtitude'];
            $station_urlServer = $_POST['station_urlServer'];
            $station_detail = $_POST['station_detail'];
            $station_user = $_POST['station_user'];

            if (empty($_SESSION['error'])) {
                // Cập nhật thông tin trạm:
                $data_station = array(
                    'name' => $station_name,
                    'longtitude' => $station_longtitude,
                    'langtitude' => $station_langtitude,
                    'detail' => $station_detail,
                    'urlServer' => $station_urlServer,
                    'user_id' => $station_user,
                );
                update_station($id, $data_station);

                $_SESSION['success'] = 'Cập nhật thông tin trạm <b>THÀNH CÔNG!</b>';
            }
        }
        header('location: ?mod=stations');
    } else {
        $id = (int) $_GET['id'];
        $station_update = get_station_by_id($id);
        $list_user_info = get_list_user_info();
        $list_sensors = get_sensors();
        $data_station = array(
            'station_update' => $station_update,
            'list_user_info' => $list_user_info,
            'list_sensors' => $list_sensors,
        );
        load_view('update', $data_station);
    }
}

function deleteStationAction()
{
    $id = (int) $_GET['id'];

    // Lấy id các cảm biến thuộc trạm:
    $sensor_ids = get_sensors_by_station_id($id);

    // Cập nhật lại cảm biến trong bảng (set connect status về 0):
    foreach ($sensor_ids as $sensor) {
        db_update('sensors', ["connect_status" => 0], $sensor['sensor_id']);
    }

    // Xóa trong bảng station_sensors:
    db_delete('station_sensors', "`station_id` = {$id}");

    // Xóa trong bảng trạm - stations:
    db_delete('stations', "`id` = {$id}");

    header('location: ?mod=stations');
}
