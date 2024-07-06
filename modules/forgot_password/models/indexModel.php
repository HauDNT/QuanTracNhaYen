<?php

function get_user_info_by_email($email) {
  $result = db_fetch_row("SELECT * FROM userinfo WHERE email = '{$email}'");
  return $result;
}