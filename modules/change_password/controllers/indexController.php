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
    'active' => 'change_password',
  );
  load_view('index', $data);
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
