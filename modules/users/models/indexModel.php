<?php

function get_list_users()
{
   $result = db_fetch_array("SELECT *, accounts.*, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND accounts.username != 'unknown' AND userinfo.id != {$_SESSION["user_info"]["id"]}  GROUP BY accounts.id ORDER BY accounts.id DESC");
   return $result;
}

function get_list_users_by_search($name, $role, $status)
{
   $sql = "SELECT *, accounts.*, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND accounts.username != 'unknown' AND userinfo.id != {$_SESSION["user_info"]["id"]} AND userinfo.fullname LIKE '%{$name}%'";
   if ($role != -1) {
      $sql .= " AND accounts.role_id = {$role}";
   }

   if ($status != -1) {
      $sql .= " AND accounts.status = {$status}";
   }

   $sql .= " GROUP BY accounts.id ORDER BY accounts.id DESC";

   $result = db_fetch_array($sql);
   return $result;
}

function get_list_users_by_username($username)
{
   $result = db_fetch_array("SELECT *, accounts.*, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND accounts.username = '{$username}'");
   return $result;
}

function get_list_users_by_email($email)
{
   $result = db_fetch_array("SELECT *, accounts.*, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND userinfo.email = '{$email}'");
   return $result;
}

function get_role_users()
{
   $result = db_fetch_array("SELECT * FROM roles");
   return $result;
}

function get_user_by_id($id)
{
   $item = db_fetch_row("SELECT *, accounts.*, roles.name FROM userinfo, accounts, roles WHERE userinfo.account_id = accounts.id AND accounts.role_id = roles.id AND accounts.id = '{$id}'");
   return $item;
}

function add_user($data_accounts = array(), $data_users = array())
{
   global $conn;
   mysqli_begin_transaction($conn);
   try {
      $id_user = db_insert('accounts', $data_accounts);
      if($id_user) {
         $data_users['account_id'] = $id_user;
         if(db_insert('userinfo', $data_users)) {
            mysqli_commit($conn);
            return true;
         } else {
            mysqli_rollback($conn);
            return false;
         }
      } else {
         mysqli_rollback($conn);
         return false;
      }
   } catch (Exception $e) {
      mysqli_rollback($conn);
      return false;
   }
}

function update_user($id, $data)
{
   return db_update('userinfo', $data, "`account_id` = '{$id}'");
}

function update_account($id, $data)
{
   return db_update('accounts', $data, "`id` = '{$id}'");
}

function update_user_info($id, $data_accounts = array(), $data_users = array())
{
   global $conn;
   mysqli_begin_transaction($conn);
   try {
      if(update_account($id, $data_accounts) && update_user($id, $data_users)) {
         mysqli_commit($conn);
         return true;
      } else {
         mysqli_rollback($conn);
         return false;
      }
   } catch (Exception $e) {
      mysqli_rollback($conn);
      return false;
   }
}