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
  date_default_timezone_set('Asia/Ho_Chi_Minh');
  $token = $_GET["token"];
  $account_info = get_account_by_token($token);
  if (empty($account_info)) {
    header('location: ?mod=logins');
  } else {
    $date_cur = new DateTime();
    $date_created = new DateTime($account_info["date_created_token"]);
    $interval = $date_created->diff($date_cur);
    $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
    if ($minutes > 5) {
      echo '<img src="public/img/Error-404.jpg" alt="" width="100%" height="100%">';
      exit();
    }
  }

  load_view('index', [
    "account_info" => $account_info
  ]);
}

function resetPasswordAction()
{
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
      echo json_encode([
        "type" => "success",
        "message" => "Vui lòng kiểm tra email để đặt lại mật khẩu.",
      ]);
    }
    exit();
  }
}

function updatePasswordAction()
{
  global $token;
  $account_info = get_account_by_token($token);
  if (isset($_POST["id"]) && isset($_POST["newPass"]) && isset($_POST["confirmPass"])) {
    $id = $_POST["id"];
    $newPass = $_POST["newPass"];
    $confirmPass = $_POST["confirmPass"];
    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/";

    if (empty($newPass)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
      ]);
    } else if (!preg_match($pattern, $newPass)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.",
      ]);
    } else if ($newPass != $confirmPass) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu không trùng khớp.",
      ]);
    } else if (update_account($id, array(
      "password" => $newPass,
      "forgot_token" => "NULL",
      "date_created_token" => "NULL"
    ))) {
      echo json_encode([
        "type" => "success",
        "message" => '
          <div class="success-form d-flex flex-column align-items-center justify-content-center">
            <i class="bi bi-check-circle text-success"></i>
            <div class="success-body text-center mb-3">
              <h3 class="text-success">Đã đổi mật khẩu!</h3>
              <h5 class="text-secondary">Mật khẩu của bạn đã được đổi thành công.</h5>
            </div>
            <a href="?mod=logins" class="btn btn-primary w-100">Tiếp tục</a>
          </div>
        ',
      ]);
    } else {
      echo json_encode([
        "type" => "fail",
        "message" => "Cập nhật thất bại.",
      ]);
    }
    exit();
  }
}
