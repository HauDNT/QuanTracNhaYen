<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function indexAction() {
    $report = get_report();
    load_view('index', $report);
}

function addAction() {
    echo "Thêm dữ liệu";
}

function editAction() {
    $id = (int)$_GET['id'];
    $item = get_user_by_id($id);
    show_array($item);
}
