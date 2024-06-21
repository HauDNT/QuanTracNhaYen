<?php

function construct() {
//    echo "DÙng chung, load đầu tiên";
    load_model('index');
}

function indexAction() {
    load_view('index');
}

function getCoorAllStationsAction() {
    $list_stations = get_stations_avg_params();

    echo json_encode($list_stations);
    exit();
}

function getPosParamsAction() {
    $result = get_position_params($_GET['station_id']);

    echo json_encode($result);
    exit();
}

function addAction() {
    echo "Thêm dữ liệu";
}

function editAction() {
    $id = (int)$_GET['id'];
    $item = get_user_by_id($id);
    show_array($item);
}
