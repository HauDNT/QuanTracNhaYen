<?php
function construct()
{
  load_model('index');
}

function indexAction()
{
  // Lấy danh sách các đơn vị đo:
  $list_indicators = get_list_indicators();
  if (isset($_POST["search"])) {
    $list_indicators = get_list_indicators_by_name($_POST["search"]);
  }

  $data_list = array();
  foreach ($list_indicators as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'name' => $value['name'],
      'unit' => $value['unit'],
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

  $data = array(
    'active' => 'indicator',
    'list_indicators' => $currentItems,
    'total_page' => $total_page,
    'current_page' => $current_page,
  );

  load_view('index', $data);
}

function addIndicatorAction()
{
  if (isset($_POST['indicator_name']) && isset($_POST['indicator_unit'])) {
    $indicator_name = $_POST['indicator_name'];
    $indicator_unit = $_POST['indicator_unit'];
    if (empty($indicator_name) || empty($indicator_unit)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
      exit();
    }

    $data = array(
      'name' => $indicator_name,
      'unit' => $indicator_unit
    );

    if (db_insert('indicators', $data)) {
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

function updateIndicatorAction()
{
  if (isset($_POST['indicator_id'])) {
    $indicator_name = $_POST['indicator_name'];
    $indicator_unit = $_POST['indicator_unit'];
    if (empty($indicator_name) || empty($indicator_unit)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
      exit();
    }

    $data = array(
      'name' => $indicator_name,
      'unit' => $indicator_unit,
    );
    if (update_indicator($_POST['indicator_id'], $data)) {
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
    $id = (int) $_GET['id'];
    $indicator_update = get_indicator_by_id($id);

    $data = array(
      'indicator_update' => $indicator_update,
    );

    load_view('update', $data);
  }
}

function deleteIndicatorAction()
{
  $id = (int) $_GET['id'];

  db_delete('indicators', "`id` = {$id}");
  header('location: ?mod=indicators');
}
