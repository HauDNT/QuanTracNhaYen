<?php

function construct()
{
    //    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function indexAction()
{
    $list_sensor = get_list_sensor_info();
    if (isset($_POST["search"])) {
        $list_sensor = get_list_sensor_by_name($_POST["search"]);
    }
    $list_station = get_list_station();
    $data = array(
        'active' => 'sensor',
        'list_sensor' => $list_sensor,
        'list_station' => $list_station,
    );
    load_view('index', $data);
}

function addSensorAction()
{
    if (isset($_POST['nameSensor'])) {
        $data = array(
            'id' => $_POST["idSensor"],
            'name' => $_POST["nameSensor"],
            'station_id' => $_POST["stationSensor"],
            'position' => $_POST["positionSensor"],
        );

        if(db_insert('sensors', $data)) {
            echo 'success';
        } else {
            echo 'fail';
        }
        exit();
    }
}

function updateSensorAction()
{
    if (isset($_POST['idSensor'])) {
        $id = (int) $_GET['id'];
        show_array($id);
        if (empty($_POST['name_sensor'])) {
            $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        } else {
            $name_sensor = $_POST['name_sensor'];

            if (empty($_SESSION['error'])) {
                $data = array(
                    'name' => $name_sensor,
                );
                update_sensor($id, $data);
                $_SESSION['success'] = 'Cập nhật cảm biến <b>THÀNH CÔNG!</b>';
            }
        }
        header('location: ?mod=sensors');
    } else {
        $id = (int)$_GET['id'];
        $sensor_update = get_sensor_by_id($id);
        $list_station = get_list_station();
        $data = array(
            'sensor_update' => $sensor_update,
            'list_station' => $list_station,
        );
        load_view('update', $data);
    }
}

function deleteSensorAction()
{
    $id = (int) $_GET['id'];
    db_delete('sensors', "`id` = {$id}");
    header('location: ?mod=sensors');
}
