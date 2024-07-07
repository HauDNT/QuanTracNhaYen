<?php

function construct()
{
  if (!isset($_SESSION["user_info"])) {
    header('location: ?mod=logins');
  }
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  $data = array(
    'active' => 'personal',
    'user_info' => get_user_info_by_id($_SESSION["user_info"]["id"])
  );
  load_view('index', $data);
}

function updateAvatarAction()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $files = $_FILES['avatar'];
    $uploadDirectory = 'public/uploads/';

    if (!is_dir($uploadDirectory)) {
      mkdir($uploadDirectory, 0755, true);
    }

    $originalFileName = pathinfo($files['name'], PATHINFO_FILENAME);
    $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
    $fileName = $originalFileName . '_' . time() . '.' . $extension;
    $filePath = $uploadDirectory . $fileName;

    if (move_uploaded_file($files['tmp_name'], $filePath)) {
      if ($_SESSION["user_info"]["avatar"] != "public\uploads\avatar-default.jpg") {
        unlink($_SESSION["user_info"]["avatar"]);
      }
      if (update_user_info($_SESSION["user_info"]["id"], array('avatar' => $filePath))) {
        $_SESSION["user_info"]["avatar"] = $filePath;
        echo json_encode([
          "type" => "success",
          "message" => "Cập nhật thành công.",
          "notifyType" => "success"
        ]);
      } else {
        echo json_encode([
          "type" => "fail",
          "message" => "Cập nhật thất bại.",
          "notifyType" => "danger"
        ]);
      }
    } else {
      echo json_encode([
        "type" => "fail",
        "message" => "Cập nhật thất bại.",
        "notifyType" => "danger"
      ]);
    }
    exit();
  }
}

function updateInfoAction()
{
  if (isset($_POST["full_name"]) && isset($_POST["gender"]) && isset($_POST["birthday"])) {
    $full_name = $_POST["full_name"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    if (empty($full_name) || empty($birthday)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
        "notifyType" => "warning"
      ]);
    } else {
      $data = array(
        "fullname" => $full_name,
        "gender" => $gender,
        "birthday" => date('Y-m-d', strtotime($birthday))
      );
      if (update_user_info($_SESSION["user_info"]["id"], $data)) {
        $_SESSION["user_info"]["fullname"] = $full_name;
        $_SESSION["user_info"]["gender"] = $gender;
        $_SESSION["user_info"]["birthday"] = $birthday;
        echo json_encode([
          "type" => "success",
          "message" => "Cập nhật thành công.",
          "notifyType" => "success"
        ]);
      } else {
        echo json_encode([
          "type" => "fail",
          "message" => "Cập nhật thất bại.",
          "notifyType" => "danger"
        ]);
      }
    }
    exit();
  }
}
