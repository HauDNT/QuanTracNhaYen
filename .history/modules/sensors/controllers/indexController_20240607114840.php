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

        if (db_insert('sensors', $data)) {
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
        $data = array(
            'id' => $_POST["idSensor"],
            'name' => $_POST["nameSensor"],
            'station_id' => $_POST["stationSensor"],
            'position' => $_POST["positionSensor"],
        );
        db_insert('sensors', $data);
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
