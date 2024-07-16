<?php

function construct()
{
  load_model('index');
  load('helper', 'sendMail');
}

function mailerSettingAction()
{
  if (isset($_GET['station_id'])) {
    $station_id = $_GET['station_id'];
    $data = get_mailer_setting_by_station_id($station_id);
    if (!empty($data)) {
      echo json_encode($data);
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  }
}

function sendMailAction() {
  if (isset($_GET['station_id']) && isset($_GET['subject']) && isset($_GET['container'])) {
    $station_id = $_GET['station_id'];
    $subject = $_GET['subject'];
    $container = $_GET['container'];
    $data = get_mailer_setting_by_station_id($station_id);
    if(sendMail($data['sender_email'], $data['sender_password	'], $data['sender_name'], $data['email'], $subject, $container)) {
      echo "Send mail success.";
    } else {
      echo "Send mail fail!!!";
    }
  }
}

function motorStateAction()
{
  if (isset($_GET['sensor_id'])) {
    $sensor_id = $_GET['sensor_id'];
    $data = get_motor_state_sensor_id($sensor_id);
    if (!empty($data)) {
      echo json_encode($data);
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  }
}

function thresholdDHTAction()
{
  if (isset($_GET['sensor_id'])) {
    $sensor_id = $_GET['sensor_id'];
    $data = get_threshold_DHT_by_sensor_id($sensor_id);
    if (!empty($data)) {
      echo json_encode($data);
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  }
}

function timeSendDataAction()
{
  if (isset($_GET['sensor_id'])) {
    $sensor_id = $_GET['sensor_id'];
    $data = get_time_send_data_by_sensor_id($sensor_id);
    if (!empty($data)) {
      echo json_encode($data);
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  }
}

function timeSetterAction()
{
  if (isset($_GET['sensor_id'])) {
    $sensor_id = $_GET['sensor_id'];
    $data = get_time_setter_by_sensor_id($sensor_id);
    if (!empty($data)) {
      echo json_encode($data);
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  }
}

function indicatorAction()
{
  if (isset($_GET['temp'])) {
    $data = get_id_indicators_by_name("Nhiệt độ");
    if (!empty($data)) {
      echo json_encode(array("temp_unit_id" => $data["id"]));
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  } else if (isset($_GET['humid'])) {
    $data = get_id_indicators_by_name("Độ ẩm");
    if (!empty($data)) {
      echo json_encode(array("humid_unit_id" => $data["id"]));
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  } else if (isset($_GET['fire'])) {
    $data = get_id_indicators_by_name("Lửa");
    if (!empty($data)) {
      echo json_encode(array("fire_unit_id" => $data["id"]));
    } else {
      echo json_encode(array("error" => "No data found."));
    }
  } else {
    echo json_encode(array("error" => "No data found."));
  }
}
