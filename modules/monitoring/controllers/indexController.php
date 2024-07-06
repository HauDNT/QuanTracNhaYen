<?php

function construct()
{
  if(!isset($_SESSION["user_info"])) {
    header('location: ?mod=logins');
  } 
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
  load('helper', 'sendPusher');
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
    if (empty($_POST['name']) || empty($_POST['longitude']) || empty($_POST['latitude']) || empty($_POST['address']) || empty($_POST['user'])) {
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
        'address' => $_POST['address'],
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
    if (empty($_POST['name']) || empty($_POST['longitude']) || empty($_POST['latitude']) || empty($_POST['address']) || empty($_POST['user'])) {
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
        'address' => $_POST['address'],
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

function showChartAction()
{
  if (isset($_POST["station_id"]) && isset($_POST["position"])) {
    echo json_encode([
      "legend" => get_data_chart_legend($_POST["station_id"], $_POST["position"]),
      "data" => get_data_chart($_POST["station_id"], $_POST["position"]),
      "label" => get_data_chart_label($_POST["station_id"], $_POST["position"])
    ]);
    exit();
  } else {
    $station_id = (int) $_GET["id"];
    $station = get_station_by_id($station_id);
    $position_list = get_position_station_by_station_id($station_id);
    $data = array(
      'station' => $station,
      'position_list' => $position_list,
    );
    load_view('chart', $data);
  }
}

function addValueAction()
{
  global $conn;
  if (isset($_POST["temperature"]) && isset($_POST["humidity"]) && isset($_POST["fire"]) && isset($_POST["dht_id"]) && isset($_POST["flame_id"])) {
    $temperature = $_POST["temperature"];
    $humidity = $_POST["humidity"];
    $fire = $_POST["fire"];
    $dht_id = get_id_by_sensor_id($_POST["dht_id"])["id"];
    $flame_id = get_id_by_sensor_id($_POST["flame_id"])["id"];

    // Insert  
    $sql = "INSERT INTO sensor_values (sensor_id, value, indicator_id) VALUES 
              ($dht_id, " . $humidity . ", 13),
              ($dht_id, " . $temperature . ", 12),
              ($flame_id, " . $fire . ", 15)";

    if (mysqli_query($conn, $sql)) {
      sendPusherEvent("pusher", "sensor", []);
      echo "Thêm dữ liệu cảm biến thành công!";
    } else {
      echo "Thêm dữ liệu cảm biến không thành công!";
    }
  }
}
