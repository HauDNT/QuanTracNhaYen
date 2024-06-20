<?php

function get_list_users() {
    $result = db_fetch_array("SELECT *, accounts.username, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND accounts.username != 'unknown'");
    return $result;
}

function get_role_users() {
    $result = db_fetch_array("SELECT * FROM roles");
    return $result;
}

function get_user_by_id($id) {
    $item = db_fetch_row("SELECT *, accounts.username, accounts.role_id, roles.name FROM `userinfo`, accounts, roles WHERE `account_id` = {$id} AND accounts.id = {$id} AND accounts.role_id = roles.id");
    return $item;
}

function update_user($id, $data) {
    db_update('userinfo', $data, "`account_id` = '{$id}'");
}

function update_account($id, $data) {
    db_update('accounts', $data, "`id` = '{$id}'");
}