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

function loginAction()
{
  if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/";
    if (empty($username) || empty($password)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin.",
      ]);
    } else if (!preg_match($pattern, $password)) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.",
      ]);
    } else {
      $account = get_account_by_username($username);
      if (empty($account) || $account["password"] != $password) {
        echo json_encode([
          "type" => "fail",
          "message" => "Tài khoản hoặc mật khẩu không đúng.",
        ]);
      } else {
        $user_info = get_user_info_by_account($username, $password);
        if ($user_info["status"] == 0) {
          echo json_encode([
            "type" => "fail",
            "message" => "Tài khoản này đã bị khóa.",
          ]);
        } else {
          $_SESSION["user_info"] = $user_info;
          echo json_encode([
            "type" => "success",
            "url" => "?mod=monitoring",
          ]);
        }
      }
    }
    exit();
  }
}

function logoutAction()
{
  unset($_SESSION['user_info']);
  session_destroy();
  header("Location:" . base_url());
}