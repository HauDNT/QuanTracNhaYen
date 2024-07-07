<?php

function get_stations()
{
  $result = db_fetch_array("SELECT * FROM `stations` ORDER BY latitude DESC");
  return $result;
}

function get_sensor_value()
{
  $result = db_fetch_array("SELECT ss.station_id, i.name, sv.value, i.unit, ss.position
  FROM sensors ss
  JOIN (SELECT sv1.*
    FROM sensor_values sv1
    JOIN (SELECT sensor_id, indicator_id, MAX(createdAt) as latest
    FROM sensor_values
    GROUP BY sensor_id, indicator_id) sv2
    ON sv1.sensor_id = sv2.sensor_id 
    AND sv1.indicator_id = sv2.indicator_id 
    AND sv1.createdAt = sv2.latest) sv ON ss.id = sv.sensor_id
  JOIN indicators i ON sv.indicator_id = i.id");
  return $result;
}

function get_position_station()
{
  $result = db_fetch_array("SELECT DISTINCT station_id, position FROM sensors");
  return $result;
}

function get_position_station_by_station_id($id)
{
  $result = db_fetch_array("SELECT DISTINCT station_id, position FROM sensors WHERE station_id = {$id}");
  return $result;
}

function get_list_station_info()
{
  $result = db_fetch_array("
        SELECT s.*, fullname, phone_number 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id");
  return $result;
}

function get_list_station_info_by_name($name)
{
  $result = db_fetch_array("
        SELECT s.*, fullname, phone_number 
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

function get_data_chart($station_id, $position)
{
  $result = db_fetch_array("WITH LatestValues AS ( SELECT ss.station_id, i.name, sv.value, i.unit, ss.position, sv.createdAt, ROW_NUMBER() OVER (PARTITION BY sv.sensor_id, sv.indicator_id ORDER BY sv.createdAt DESC) as rn FROM sensors ss JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON sv.indicator_id = i.id ) SELECT station_id, name, value, unit, position, createdAt FROM LatestValues WHERE station_id = {$station_id} AND position = {$position} AND unit != '-' AND rn <= 4 ORDER BY createdAt DESC");
  return $result;
}

function get_data_chart_legend($station_id, $position)
{
  $result = db_fetch_array("SELECT i.name FROM indicators i JOIN sensor_values sv ON i.id = sv.indicator_id JOIN sensors s ON s.id = sv.sensor_id WHERE s.station_id = {$station_id} AND s.position = {$position} AND i.unit != '-' GROUP BY i.name");
  return $result;
}

function get_data_chart_label($station_id, $position)
{
  $result = db_fetch_array("SELECT createdAt FROM sensor_values sv JOIN sensors s ON sv.sensor_id = s.id WHERE s.station_id = {$station_id} AND s.position = {$position} GROUP BY createdAt ORDER BY createdAt DESC LIMIT 4");
  return $result;
}

function get_id_by_sensor_id($sensor_id)
{
  $result = db_fetch_row("SELECT id FROM sensors WHERE sensor_id = '{$sensor_id}'");
  return $result;
}

function get_station_setting_by_station_id($station_id, $position = 1)
{
  $result = db_fetch_row("SELECT sst.* FROM sensor_settings sst JOIN sensors s ON sst.sensor_id = s.id WHERE s.position = {$position} AND s.station_id = {$station_id}");
  return $result;
}

function get_email_setting_by_station_id($station_id)
{
  $result = db_fetch_row("SELECT * FROM email_settings WHERE station_id = {$station_id}");
  return $result;
}

function update_sensor_setting($id, $data)
{
  return db_update('sensor_settings', $data, "`sensor_id` = '{$id}'");
}

function update_email_setting($id, $data)
{
  return db_update('email_settings', $data, "`station_id` = '{$id}'");
}

function update_setting($station_id, $sensor_id, $data_sensor = array(), $data_email = array())
{
  global $conn;
  mysqli_begin_transaction($conn);
  try {
    if (update_sensor_setting($sensor_id, $data_sensor) && update_email_setting($station_id, $data_email)) {
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
