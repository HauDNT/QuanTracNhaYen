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
   $data_table = get_data_table();
   if (isset($_POST["search"])) {
      $data_table = get_data_table_by_search($_POST["search"], $_POST["reportPosition"], $_POST["reportIndicator"],  $_POST["dateStart"],  $_POST["dateEnd"]);
   }

   $data_list = array();
   foreach ($data_table as $index => $value) {
      $data_list[] = array(
         'no' => $index + 1,
         'station' => $value['station'],
         'position' => $value['position'],
         'indicator' => $value['indicator'],
         'value' => $value['value'],
         'unit' => $value['unit'],
         'createdAt' => date('d-m-Y H:s:i', strtotime($value['createdAt'])),
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

   $position = get_position();
   $indicator = get_indicator();
   load_view('index', [
      'active' => 'report',
      'position' => $position,
      'indicator' => $indicator,
      'data_table' => $currentItems,
      'total_page' => $total_page,
      'current_page' => $current_page,
   ]);
}

function getChartAction()
{
   if (isset($_POST["date"])) {
      $label = get_label_month();
      $data = get_data_month();
      if($_POST["date"] == "this_week" || $_POST["date"] == "last_week") {
         $label = get_label_week();
         $data = get_data_week();
         if($_POST["date"] == "last_week") {
            $data = get_data_last_week();
         }
      }

      echo json_encode([
         "label" => $label,
         "legend" => get_indicator(),
         "data" => $data
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
