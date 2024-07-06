<?php

function get_user_info_by_id($id)
{
   $result = db_fetch_row("SELECT a.username, a.password, a.date_created, r.name, u.* FROM accounts a JOIN userinfo u ON a.id = u.account_id JOIN roles r ON a.role_id = r.id WHERE u.id = {$id}");
   return $result;
}

function update_user_info($id, $data)
{
   return db_update('userinfo', $data, "`id` = '{$id}'");
}

function get_id_account_by_id_user($id) {
   $result = db_fetch_row("SELECT a.id FROM accounts a JOIN userinfo u ON a.id = u.account_id WHERE u.id = {$id}");
   return $result;
}

function update_account($id, $data) {
   return db_update('accounts', $data, "`id` = '{$id}'");
}