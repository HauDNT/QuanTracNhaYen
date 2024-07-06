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
    'active' => 'information',
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

function updatePasswordAction()
{
  if (isset($_POST["oldPass"]) && isset($_POST["newPass"]) && isset($_POST["confirmPass"])) {
    $oldPass = $_POST["oldPass"];
    $newPass = $_POST["newPass"];
    $confirmPass = $_POST["confirmPass"];
    $user_info = get_user_info_by_id($_SESSION["user_info"]["id"]);
    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/";

    if (empty($oldPass) || empty($newPass)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
        "notifyType" => "warning"
      ]);
    } else if ($oldPass != $user_info["password"]) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu không đúng.",
        "notifyType" => "warning"
      ]);
    } else if (!preg_match($pattern, $newPass)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.",
        "notifyType" => "warning"
      ]);
    } else if ($newPass != $confirmPass) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu không trùng khớp.",
        "notifyType" => "warning"
      ]);
    } else if (update_account(get_id_account_by_id_user($_SESSION["user_info"]["id"])["id"], array("password" => $newPass))) {
      echo json_encode([
        "type" => "success",
        "message" => "Cập nhật thành công.",
        "notifyType" => "success"
      ]);
    } else {
      echo json_encode([
        "type" => "fail",
        "message" => "Cập nhật thất bại.",
        "notifyType" => "warning"
      ]);
    }
    exit();
  }
}
