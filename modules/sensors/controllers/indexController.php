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
    $list_sensor = get_list_sensor_search($_POST["search"], $_POST["status"]);
  }

  $item_per_page = 2;
  $current_page = 2;
  $total_page = ceil(count($list_sensor) / $item_per_page);
  $offset = ($current_page - 1) * $total_page;

  $data = array();
  foreach($list_sensor as $index => $value) {
    $data[] = array(
      'no' => $index + 1,
      'sensor_name' => $value['sensor_name'],
      'station_name' => $value['station_name'],
      'position' => $value['position'],
      'connect_status' => $value['connect_status']
    );
  }

  $currentItems = array_slice($data, $offset, $total_page);

  $list_station = get_list_station();
  $data = array(
    'active' => 'sensor',
    'list_sensor' => $currentItems,
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
      'name' => $_POST["nameSensor"],
      'station_id' => $_POST["stationSensor"],
      'position' => $_POST["positionSensor"],
    );
    if (update_sensor($_POST['idSensor'], $data)) {
      echo 'success';
    } else {
      echo 'fail';
    }
    exit();
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
