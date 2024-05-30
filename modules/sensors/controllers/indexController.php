<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function indexAction() {
    $list_sensor = get_list_sensor();
    $list_position = get_list_position();
    $list_station = get_list_station();
    $data = array(
        'list_sensor' => $list_sensor,
        'list_position' => $list_position,
        'list_station' => $list_station
    );
    load_view('index', $data);
}

function addSensorAction() {
    if (isset($_POST['add_sensor'])) {
        if (empty($_POST['name_sensor']) || empty($_POST['station'])) {
            $_SESSION['error'] = "<b>THÊM THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        } else {
            $name_sensor = $_POST['name_sensor'];
            $station = $_POST['station'];
        }

       if (empty($_SESSION['error'])) {
           $data = array(
               'name' => $name_sensor,
               'station_id' => $station,
           );
           
           db_insert('sensors', $data);
           $_SESSION['success'] = 'Thêm cảm biến <b>THÀNH CÔNG!</b>';
       }
    }
    header('location: ?mod=sensors');
}

function updateSensorAction() {
    if (isset($_POST['update_sensor'])) {
        $id = (int) $_GET['id'];
        show_array($id);
        if (empty($_POST['name_sensor']) || empty($_POST['station']) || empty($_POST['position'])) {
            $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        } else {
            $name_sensor = $_POST['name_sensor'];
            $station = $_POST['station'];
            $position = $_POST['position'];
            
            if (empty($_SESSION['error'])) {
                $data = array(
                    'name' => $name_sensor,
                    'station_id' => $station,
                    'position_id' => $position,
                );
                update_sensor($id, $data);
                $_SESSION['success'] = 'Cập nhật cảm biến <b>THÀNH CÔNG!</b>';
            }
        }
        header('location: ?mod=sensors');
    } else {
        $id = (int)$_GET['id'];
        $sensor_update = get_sensor_by_id($id);
        $list_position = get_list_position();
        $list_station = get_list_station();
        $data = array(
            'sensor_update' => $sensor_update,
            'list_position' => $list_position,
            'list_station' => $list_station,
        );
        load_view('update', $data);
    }
}

function deleteSensorAction() {
    $id = (int) $_GET['id'];
    db_delete('sensors', "`id` = {$id}");
    header('location: ?mod=sensors');
}