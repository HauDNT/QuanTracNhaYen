<?php

function get_mailer_setting_by_station_id($station_id) {
  $result = db_fetch_row("SELECT e.sender_name, e.sender_email, e.sender_password, u.email AS recipient_email , u.fullname AS recipient_name, e.timeSendEmail FROM email_settings e JOIN stations s ON s.id = e.station_id JOIN userinfo u ON u.account_id = s.user_id WHERE s.id = '{$station_id}'");
  return $result;
}

function get_motor_state_sensor_id($sensor_id) {
  $result = db_fetch_row("SELECT motor_status FROM sensor_settings JOIN sensors ON sensors.id = sensor_settings.sensor_id WHERE sensors.sensor_id = '{$sensor_id}'");
  return $result;
}

function get_threshold_DHT_by_sensor_id($sensor_id) {
  $result = db_fetch_row("SELECT temp_thres_min, temp_thres_max, humid_thres_min, humid_thres_max FROM sensor_settings JOIN sensors ON sensors.id = sensor_settings.sensor_id WHERE sensors.sensor_id = '{$sensor_id}'");
  return $result;
}

function get_time_send_data_by_sensor_id($sensor_id) {
  $result = db_fetch_row("SELECT time_send_data FROM sensor_settings JOIN sensors ON sensors.id = sensor_settings.sensor_id WHERE sensors.sensor_id = '{$sensor_id}'");
  return $result;
}

function get_time_setter_by_sensor_id($sensor_id) {
  $result = db_fetch_row("SELECT time_start, time_finish FROM sensor_settings JOIN sensors ON sensors.id = sensor_settings.sensor_id WHERE sensors.sensor_id = '{$sensor_id}'");
  return $result;
}

function get_id_indicators_by_name($name) {
  $result = db_fetch_row("SELECT id FROM indicators WHERE name = '{$name}'");
  return $result;
}