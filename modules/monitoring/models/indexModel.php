<?php

function get_stations()
{
  $result = db_fetch_array("SELECT * FROM `stations` ORDER BY langtitude DESC");
  return $result;
}


function get_sensor_value() {
  $result = db_fetch_array("SELECT ss.station_id, u.name, sv.value, u.symbol, ss.position FROM sensors ss JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN units u ON sv.unit_id = u.id");
  return $result;
}

function get_position_station() {
  $result = db_fetch_array("SELECT DISTINCT station_id, position FROM sensors");
  return $result;
}