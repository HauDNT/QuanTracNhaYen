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
  $data = array(
    'active' => 'unit',
    'list_units' => $list_units
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
  if (isset($_POST['update_unit'])) {
    $id = (int) $_GET['id'];
    show_array($id);

    if (empty($_POST['unit_name'])) {
      $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
    } else {
      $unit_name = $_POST['unit_name'];

      if (empty($_SESSION['error'])) {
        $data = array(
          'name' => $unit_name,
        );

        update_unit($id, $data);

        $_SESSION['success'] = 'Cập nhật đơn vị đo <b>THÀNH CÔNG!</b>';
      }
    }

    header('location: ?mod=units');
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
