<?php

function construct() {
    //    echo "DÙng chung, load đầu tiên";
        load_model('index');
    }

    function indexAction(){
        $list_position = get_list_position();
        $data = array(
            'list_position' => $list_position

        );
        load_view('index', $data);
    }

    function addPositionAction() {
        if (isset($_POST['add_position'])) {
            if (empty($_POST['name_position']) ) {
                $_SESSION['error'] = "<b>THÊM THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
            } else {
                $name_position = $_POST['name_position'];
            }
    
           if (empty($_SESSION['error'])) {
               $data = array(
                   'Position' => $name_position,
               );
               
               db_insert('position', $data);
               $_SESSION['success'] = 'Thêm tầng <b>THÀNH CÔNG!</b>';
           }
        }
        header('location: ?mod=position');
    }
    function updatePositionAction() {
        if (isset($_POST['update_position'])) {
            $id = (int) $_GET['id'];
    
            if (empty($_POST['Position'])) {
                $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
            } else {
                $name_position = $_POST['Position'];
                
                if (empty($_SESSION['error'])) {
                    $data = array(
                        'Position' => $name_position,
                    );
                    update_position($id, $data); // Giả định update_sensor là hàm để cập nhật dữ liệu trong DB
                    $_SESSION['success'] = 'Cập nhật tầng <b>THÀNH CÔNG!</b>';
                }
            }
            header('Location: ?mod=position');
            exit();
        } else {
            $id = (int)$_GET['id'];
            $position_update = get_position_by_id($id);
          
            $data = array(
                'position_update' => $position_update,
            );
            load_view('update', $data); // Giả định load_view là hàm để tải view
        }
    }
    
    
    function deletePositionAction() {
        $id = (int) $_GET['id'];
        db_delete('position', "`id` = {$id}");
        header('location: ?mod=position');
    }