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

  $data_list = array();
  foreach ($list_sensor as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'sensor_name' => $value['sensor_name'],
      'station_name' => $value['station_name'],
      'position' => $value['position'],
      'connect_status' => $value['connect_status']
    );
  }

  $item_per_page = 10;
  $current_page = 1;
  if (isset($_POST["page"])) {
    $current_page = $_POST["page"];
  }
  $total_page = ceil(count($data_list) / $item_per_page);
  $offset = ($current_page - 1) * $item_per_page;

  $currentItems = array_slice($data_list, $offset, $item_per_page);

  $list_station = get_list_station();
  $data = array(
    'active' => 'sensor',
    'list_sensor' => $currentItems,
    'list_station' => $list_station,
    'total_page' => $total_page,
    'current_page' => $current_page,
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
