<?php
function construct() {
    load_model('index');
}

function indexAction() {
    // Lấy danh sách các đơn vị đo:
    $list_units = get_list_units();
    $data = array(
        'list_units' => $list_units
    );

    load_view('index', $data);
}

function addUnitAction() {
    if (isset($_POST['add_unit'])) {
        if (empty($_POST['unit_name'])) {
            $_SESSION['error'] = "<b>THÊM THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        }
        else {
            $unit_name = $_POST['unit_name'];
        }

        if (empty($_SESSION['error'])) {
            $data_unit = array(
                'name' => $unit_name,
            );

            db_insert('units', $data_unit);

            $_SESSION['success'] = 'Thêm đơn vị đo mới <b>THÀNH CÔNG!</b>';
        }
    }
    header('location: ?mod=units');
}

function updateUnitAction() {
    if (isset($_POST['update_unit'])) {
        $id = (int) $_GET['id'];
        show_array($id);

        if (empty($_POST['unit_name'])) {
            $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
        }
        else {
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
    }
    else {
        $id = (int) $_GET['id'];
        $unit_update = get_unit_by_id($id);

        $data = array(
            'unit_update' => $unit_update,
        );

        load_view('update', $data);
    }
}

function deleteUnitAction() {
    $id = (int) $_GET['id'];

    db_delete('units', "`id` = {$id}");
    header('location: ?mod=units');
}