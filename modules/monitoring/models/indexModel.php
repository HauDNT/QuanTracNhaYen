<?php

function get_stations()
{
  $result = db_fetch_array("SELECT * FROM `stations` ORDER BY latitude DESC");
  return $result;
}

function get_sensor_value()
{
  $result = db_fetch_array("SELECT ss.station_id, i.name, sv.value, i.unit, ss.position FROM sensors ss JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON sv.indicator_id = i.id");
  return $result;
}

function get_position_station()
{
  $result = db_fetch_array("SELECT DISTINCT station_id, position FROM sensors");
  return $result;
}

function get_list_station_info()
{
  $result = db_fetch_array("
        SELECT s.id, s.name, s.longitude, s.latitude, s.urlServer, fullname 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id");
  return $result;
}

function get_list_station_info_by_name($name)
{
  $result = db_fetch_array("
        SELECT s.id, s.name, s.longitude, s.latitude, s.urlServer, fullname 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id
        WHERE s.name LIKE '%$name%'");
  return $result;
}

function get_sensor_id_by_station_id($id)
{
  $result = db_fetch_array("SELECT id FROM sensors WHERE station_id = {$id}");
  return $result;
}

function delete_station($id)
{
  global $conn;
  mysqli_begin_transaction($conn);
  try {
    if (!empty(get_sensor_id_by_station_id($id))) {
      $sensor_id = get_sensor_id_by_station_id($id)[0]["id"];
      $data = array(
        "connect_status" => "0",
        "station_id" => null
      );
      if (db_update('sensors', $data, "`id` = '{$sensor_id}'")) {
        if (db_delete('stations', "`id` = {$id}")) {
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
    } else {
      if (db_delete('stations', "`id` = {$id}")) {
        mysqli_commit($conn);
        return true;
      } else {
        mysqli_rollback($conn);
        return false;
      }
    }
  } catch (Exception $e) {
    mysqli_rollback($conn);
    return false;
  }
}

function get_list_user_info()
{
  $result = db_fetch_array("SELECT * FROM userinfo");
  return $result;
}

function update_station($id, $data)
{
  return db_update('stations', $data, "`id` = '{$id}'");
}

function get_station_by_id($id)
{
  $result = db_fetch_row("SELECT * FROM `stations` WHERE `id` = {$id}");
  return $result;
}