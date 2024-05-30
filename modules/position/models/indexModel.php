<?php

function get_list_position(){
    $result = db_fetch_array("SELECT * FROM position");
    return $result;
}

function get_position_by_id($id) {
    $item = db_fetch_row("SELECT * FROM `position` WHERE `id` = {$id}");
    return $item;
}
function update_position($id, $data) {
    db_update('position', $data, "`id` = '{$id}'");
}