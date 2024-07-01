<?php

function construct()
{
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  if(isset($_POST["get_data"])) {
    echo json_encode([
      "station" => get_stations(),
      "sensor_value" => get_sensor_value(),
      "position_list" => get_position_station(),
    ]);
    exit();
  }
  load_view('index', [
    'active' => 'monitoring',
  ]);
}

function addAction()
{
  echo "Thêm dữ liệu";
}

function editAction()
{
  $id = (int)$_GET['id'];
  $item = get_user_by_id($id);
  show_array($item);
}
