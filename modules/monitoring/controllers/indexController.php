<?php

function construct()
{
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  if (isset($_POST["get_data"])) {
    echo json_encode([
      "station" => get_stations(),
      "sensor_value" => get_sensor_value(),
      "position_list" => get_position_station(),
    ]);
    exit();
  } else {
    $list_station_info = get_list_station_info();
    if (isset($_POST["search"])) {
      $list_station_info = get_list_station_info_by_name($_POST["search"]);
    }

    load_view('index', [
      'active' => 'monitoring',
      'list_station_info' => $list_station_info,
      'list_user_info' => get_list_user_info(),
    ]);
  }
}

function addStationAction()
{
  if (isset($_POST['name']) && isset($_POST['longitude']) && isset($_POST['latitude']) && isset($_POST['user'])) {
    if (empty($_POST['name']) || empty($_POST['longitude']) || empty($_POST['latitude']) || empty($_POST['user'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
    } else {
      $data_stations = array(
        'name' => $_POST['name'],
        'longitude' => $_POST['longitude'],
        'latitude' => $_POST['latitude'],
        'urlServer' => empty($_POST["urlWeb"]) ? null : $_POST["urlWeb"],
        'user_id' => $_POST['user'],
      );

      if (db_insert('stations', $data_stations)) {
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
    }
  }
  exit();
}

function updateStationAction()
{
  if (isset($_POST["id"]) && isset($_POST['name']) && isset($_POST['longitude']) && isset($_POST['latitude']) && isset($_POST['user'])) {
    if (empty($_POST['name']) || empty($_POST['longitude']) || empty($_POST['latitude']) || empty($_POST['user'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
    } else {
      $data_stations = array(
        'name' => $_POST['name'],
        'longitude' => $_POST['longitude'],
        'latitude' => $_POST['latitude'],
        'urlServer' => empty($_POST["urlWeb"]) ? null : $_POST["urlWeb"],
        'user_id' => $_POST['user'],
      );

      if (update_station($_POST["id"], $data_stations)) {
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
    }
  } else {
    $id = (int) $_GET['id'];
    $station_update = get_station_by_id($id);
    $list_user_info = get_list_user_info();
    $data_station = array(
      'station_update' => $station_update,
      'list_user_info' => $list_user_info,
    );
    load_view('update', $data_station);
  }
  exit();
}
function deleteStationAction()
{
  $id = (int) $_GET['id'];
  delete_station($id);
  header('location: ?mod=monitoring');
}
