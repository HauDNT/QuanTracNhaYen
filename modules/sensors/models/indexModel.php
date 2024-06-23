<?php

function get_list_sensor_info() {
    $result = db_fetch_array("SELECT s.id, s.name AS sensor_name, s.position, st.name AS station_name, s.connect_status FROM sensors s JOIN stations st ON s.station_id = st.id");
    return $result;
}

function get_list_sensor_by_name($name) {
    $result = db_fetch_array("SELECT s.id, s.name AS sensor_name, s.position, st.name AS station_name, s.connect_status FROM sensors s JOIN stations st ON s.station_id = st.id
    WHERE s.name LIKE '%".$name."%'");
    return $result;
}

function get_list_station() {
    $result = db_fetch_array("SELECT *  FROM stations ");
    return $result;
}

function get_sensor_by_id($id) {
    $item = db_fetch_row("SELECT s.id, s.name AS sensor_name, s.position, st.id AS station_id, st.name AS station_name, s.connect_status FROM sensors s JOIN stations st ON s.station_id = st.id WHERE s.id = {$id}");
    return $item;
}

function update_sensor($id, $data) {
    return db_update('sensors', $data, "`id` = '{$id}'");
}