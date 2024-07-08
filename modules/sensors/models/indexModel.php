<?php

function get_list_sensor_info()
{
  $result = db_fetch_array("SELECT s.id, s.sensor_id, s.name AS sensor_name, s.position, st.name AS station_name, s.connect_status FROM sensors s LEFT JOIN stations st ON s.station_id = st.id ORDER BY s.id DESC");
  return $result;
}

function get_list_sensor_search($name, $status)
{
  $select = "SELECT s.id, s.sensor_id, s.name AS sensor_name, s.position, st.name AS station_name, s.connect_status FROM sensors s LEFT JOIN stations st ON s.station_id = st.id WHERE s.name LIKE '%{$name}%'";
  if ($status != -1) {
    $select .= " AND s.connect_status = '{$status}'";
  }
  $select .= " ORDER BY s.id DESC";
  $result = db_fetch_array($select);
  return $result;
}

function get_list_station()
{
  $result = db_fetch_array("SELECT *  FROM stations");
  return $result;
}

function get_sensor_by_id($id)
{
  $item = db_fetch_row("SELECT s.id, s.sensor_id, s.name AS sensor_name, s.position, st.id AS station_id, st.name AS station_name, s.connect_status, s.threshold_setting FROM sensors s LEFT JOIN stations st ON s.station_id = st.id WHERE s.id = {$id}");
  return $item;
}

function get_sensor_by_sensor_id($id)
{
  $item = db_fetch_row("SELECT s.id, s.sensor_id, s.name AS sensor_name, s.position, st.id AS station_id, st.name AS station_name, s.connect_status FROM sensors s LEFT JOIN stations st ON s.station_id = st.id WHERE s.sensor_id = '{$id}'");
  return $item;
}

function get_sensor_max_id()
{
  $result = db_fetch_array("SELECT id FROM `sensors` ORDER BY id DESC LIMIT 1");
  return $result;
}

function update_sensor($id, $data)
{
  return db_update('sensors', $data, "`sensor_id` = '{$id}'");
}

function delete_sensor($id)
{
  global $conn;
  mysqli_begin_transaction($conn);
  try {
    if (
      db_delete('sensor_settings', "sensor_id = {$id}") &&
      db_delete('sensor_values', "sensor_id = {$id}") &&
      db_delete('avgvalues', "sensor_id = {$id}") &&
      db_delete('sensors', "id = {$id}")
    ) {
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
