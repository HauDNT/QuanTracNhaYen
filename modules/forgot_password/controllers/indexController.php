<?php

function construct()
{
  if (isset($_SESSION["user_info"])) {
    header('location: ?mod=monitoring');
  }
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
  load('helper', 'sendMail');
  load('helper', 'url');
}

function indexAction()
{
  load_view('index');
}

function resetPasswordAction()
{
  date_default_timezone_set('Asia/Ho_Chi_Minh');
  if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    if (empty(($email))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
      ]);
    } else if (!preg_match($emailPattern, $email)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Định dang gmail không hợp lệ.",
      ]);
    } else if (empty(get_user_info_by_email($email))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Email không tồn tại trong hệ thống.",
      ]);
    } else {
      $id = get_account_by_id(get_user_info_by_email($email)["account_id"])["id"];
      $token = sha1($id. time());
      $date = new DateTime();
      $date = $date->format('Y-m-d H:i:s');
      $data = array(
        "forgot_token" => $token,
        "date_created_token" => $date
      );

      if (update_account($id, $data)) {
        $htmlContent = file_get_contents(base_url('libraries/email_template/reset_password.html'));
        $htmlContent = str_replace('{{name}}', get_user_info_by_email($email)["fullname"], $htmlContent);
        $htmlContent = str_replace('{{link}}', base_url('?mod=reset_password&token=' . $token), $htmlContent);

        if (sendMail($email, "Đặt lại mật khẩu", $htmlContent)) {
          echo json_encode([
            "type" => "success",
            "message" => "Vui lòng kiểm tra email để đặt lại mật khẩu.",
          ]);
        } else {
          echo json_encode([
            "type" => "fail",
            "message" => "Gửi thất bại, vui lòng thử lại sau.",
          ]);
        }
      } else {
        echo json_encode([
          "type" => "fail",
          "message" => "Gửi thất bại, vui lòng thử lại sau.",
        ]);
      }
    }
    exit();
  }
}
