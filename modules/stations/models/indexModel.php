<?php

function get_list_station_info() {
    $result = db_fetch_array("
        SELECT s.id, s.name, s.longtitude, s.langtitude, s.urlServer, p.Position, fullname 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id
        JOIN position p ON s.position_id = p.id");
    return $result;
}

function get_list_position() {
    $result = db_fetch_array("SELECT *  FROM position ");
    return $result;
}

function get_list_user_info() {
    $result = db_fetch_array("SELECT * FROM userinfo");
    return $result;
}

function get_station_by_id($id) {
    $result = db_fetch_row("SELECT * FROM `stations` WHERE `id` = {$id}");
    return $result;
} 

function update_station($id, $data) {
    db_update('stations', $data, "`id` = '{$id}'");
}

function get_sensors_unconnect() {
    $result = db_fetch_array("SELECT * FROM sensors");
    return $result;
}

function get_sensors_by_station_id($id) {
    $result = db_fetch_array("SELECT sensor_id FROM station_sensors WHERE station_id = '{$id}'");
    return $result;
}
?>