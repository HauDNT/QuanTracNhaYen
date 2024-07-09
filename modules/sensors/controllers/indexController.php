<?php

function construct()
{
  if (!isset($_SESSION["user_info"])) {
    header('location: ?mod=logins');
  }
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  $list_sensor = get_list_sensor_info();
  if (isset($_POST["search"])) {
    $list_sensor = get_list_sensor_search($_POST["search"], $_POST["sensorStatus"]);
  }

  $data_list = array();
  foreach ($list_sensor as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'sensor_id' => $value['sensor_id'],
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
    'max_id' => (int)get_sensor_max_id()[0]["id"],
    'current_page' => $current_page,
  );
  load_view('index', $data);
}

function addSensorAction()
{
  if (isset($_POST["idSensor"]) && isset($_POST['nameSensor'])) {
    if (empty($_POST["idSensor"]) || empty($_POST["nameSensor"]) || empty($_POST["positionSensor"])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
      exit();
    }

    if (!empty(get_sensor_by_sensor_id($_POST["idSensor"]))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mã đã tồn tại!",
        "notifyType" => "warning",
      ]);
      exit();
    }

    $data = array(
      'sensor_id' => $_POST["idSensor"],
      'name' => $_POST["nameSensor"],
      'station_id' => empty($_POST["stationSensor"]) ? null : $_POST["stationSensor"],
      'position' => $_POST["positionSensor"],
      'threshold_setting' => $_POST["threshold_setting"]
    );

    if (db_insert('sensors', $data)) {
      echo json_encode([
        "type" => "success",
        "message" => "Thêm thành công.",
        "notifyType" => "success"
      ]);
    } else {
      echo json_encode([
        "type" => "fail",
        "message" => "Thêm thất bại.",
        "notifyType" => "danger"
      ]);
    }
    exit();
  }
}

function updateSensorAction()
{
  if (isset($_POST['idSensor'])) {
    if (empty($_POST["idSensor"]) || empty($_POST["nameSensor"]) || empty($_POST["stationSensor"]) || empty($_POST["positionSensor"])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
      exit();
    }

    $data = array(
      'name' => $_POST["nameSensor"],
      'station_id' => empty($_POST["stationSensor"]) ? null : $_POST["stationSensor"],
      'position' => $_POST["positionSensor"],
      'threshold_setting' => $_POST["threshold_setting"]
    );
    if (update_sensor($_POST['idSensor'], $data)) {
      echo json_encode([
        "type" => "success",
        "message" => "Cập nhật thành công.",
        "notifyType" => "success"
      ]);
    } else {
      echo json_encode([
        "type" => "fail",
        "message" => "Cập nhật thất bại.",
        "notifyType" => "danger"
      ]);
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

  delete_sensor($id);
  header('location: ?mod=sensors');
}
