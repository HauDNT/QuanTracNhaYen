<?php

function get_list_sensor() {
    $result = db_fetch_array("SELECT * FROM sensors");
    return $result;
}

function get_list_sensor_by_name($name) {
    $result = db_fetch_array("SELECT * FROM sensors WHERE name LIKE '%{$name}%'");
    return $result;
}

function get_list_position() {
    $result = db_fetch_array("SELECT *  FROM position ");
    return $result;
}

function get_list_station() {
    $result = db_fetch_array("SELECT *  FROM stations ");
    return $result;
}

function get_sensor_by_id($id) {
    $item = db_fetch_row("SELECT * FROM `sensors` WHERE `id` = {$id}");
    return $item;
}

function update_sensor($id, $data) {
    db_update('sensors', $data, "`id` = '{$id}'");
}