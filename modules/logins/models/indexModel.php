<?php

function get_account_by_username($username)
{
   $result = db_fetch_row("SELECT * FROM accounts WHERE username = '{$username}'");
   return $result;
}

function get_user_info_by_account($username, $password)
{
   $result = db_fetch_row("SELECT a.username, a.password, a.status, a.role_id, u.* FROM accounts a JOIN userinfo u ON a.id = u.account_id WHERE username = '{$username}' AND password = '{$password}'");
   return $result;
}
