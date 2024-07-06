<?php

function construct()
{
  if (isset($_SESSION["user_info"])) {
    header('location: ?mod=monitoring');
  }
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  load_view('index');
}

function resetPasswordAction() {
  if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    if(empty(($email))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
      ]);
    } else if (!preg_match($emailPattern, $email)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Định dang gmail không hợp lệ.",
      ]);
    } else if(empty(get_user_info_by_email($email))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Email không tồn tại trong hệ thống.",
      ]);
    } else {
      echo json_encode([
        "type" => "success",
        "message" => "Vui lòng kiểm tra email để đặt lại mật khẩu.",
      ]);
    }
    exit();
  }
}