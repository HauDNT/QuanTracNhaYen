<?php

function get_list_users() {
    $result = db_fetch_array("SELECT * FROM `tbl_users`");
    return $result;
}

function get_user_by_id($id) {
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `user_id` = {$id}");
    return $item;
}

function get_report() {
    $result = db_fetch_array("SELECT s.name, st.name, p.Position, sv.value, sv.unit_id, sv.createdAt FROM sensors s JOIN stations st ON s.station_id = st.id JOIN position p ON s.position_id = p.id JOIN sensor_values sv ON s.id = sv.sensor_id");
    return $result;
}