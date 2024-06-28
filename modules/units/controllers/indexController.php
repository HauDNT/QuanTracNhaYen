<?php
function construct()
{
  load_model('index');
}

function indexAction()
{
  // Lấy danh sách các đơn vị đo:
  $list_units = get_list_units();
  if (isset($_POST["search"])) {
    $list_units = get_list_units_by_name($_POST["search"]);
  }

  $data_list = array();
  foreach ($list_units as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'name' => $value['name'],
      'symbol' => $value['symbol'],
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
    'active' => 'unit',
    'list_units' => $currentItems,
    'total_page' => $total_page,
    'current_page' => $current_page,
  );

  load_view('index', $data);
}

function addUnitAction()
{
  if (isset($_POST['unit_name']) && isset($_POST['unit_symbol'])) {
    $unit_name = $_POST['unit_name'];
    $unit_symbol = $_POST['unit_symbol'];

    $data = array(
      'name' => $unit_name,
      'symbol' => $unit_symbol
    );

    if (db_insert('units', $data)) {
      echo 'success';
    } else {
      echo 'fail';
    }
    exit();
  }
}

function updateUnitAction()
{
  if (isset($_POST['unit_id'])) {
    $data = array(
      'name' => $_POST["unit_name"],
      'symbol' => $_POST["unit_symbol"],
    );
    if (update_unit($_POST['unit_id'], $data)) {
      echo 'success';
    } else {
      echo 'fail';
    }
    exit();
  } else {
    $id = (int) $_GET['id'];
    $unit_update = get_unit_by_id($id);

    $data = array(
      'unit_update' => $unit_update,
    );

    load_view('update', $data);
  }
}

function deleteUnitAction()
{
  $id = (int) $_GET['id'];

  db_delete('units', "`id` = {$id}");
  header('location: ?mod=units');
}
