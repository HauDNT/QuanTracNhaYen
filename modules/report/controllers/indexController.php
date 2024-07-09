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
   $station = get_station();
   $indicator = get_indicator();
   load_view('index', [
      'active' => 'report',
      'station' => $station,
      'indicator' => $indicator
   ]);
}

function getChartAction()
{
   if (isset($_POST["getChart"])) {
      echo json_encode([
         "label" => get_label_month(),
         "legend" => get_indicator(),
         "data" => get_data_month()
      ]);
      exit();
   }
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
