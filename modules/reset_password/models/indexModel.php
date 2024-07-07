<?php

function get_user_info_by_email($email)
{
  $result = db_fetch_row("SELECT * FROM userinfo WHERE email = '{$email}'");
  return $result;
}

function get_account_by_token($token)
{
  $result = db_fetch_row("SELECT * FROM accounts WHERE forgot_token = '{$token}'");
  return $result;
}

function update_account($id, $data)
{
  return db_update('accounts', $data, "`id` = '{$id}'");
}
