<?php

function get_list_station_info()
{
  $result = db_fetch_array("
        SELECT s.id, s.name, s.longtitude, s.langtitude, s.urlServer, fullname 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id");
  return $result;
}

function get_list_station_info_by_name($name)
{
  $result = db_fetch_array("
        SELECT s.id, s.name, s.longtitude, s.langtitude, s.urlServer, fullname 
        FROM stations s 
        JOIN userinfo u ON s.user_id = u.account_id
        WHERE s.name LIKE '%$name%'");
  return $result;
}

function get_list_user_info()
{
  $result = db_fetch_array("SELECT * FROM userinfo");
  return $result;
}

function get_station_by_id($id)
{
  $result = db_fetch_row("SELECT * FROM `stations` WHERE `id` = {$id}");
  return $result;
}

function update_station($id, $data)
{
  db_update('stations', $data, "`id` = '{$id}'");
}

function get_sensors()
{
  $result = db_fetch_array("SELECT * FROM sensors");
  return $result;
}

function get_sensors_by_station_id($id)
{
  $result = db_fetch_array("SELECT id FROM sensors WHERE sensors.station_id = {$id}");
  return $result;
}
