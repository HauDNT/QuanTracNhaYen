<?php

function construct()
{
  if (!isset($_SESSION["user_info"])) {
    header('location: ?mod=logins');
  }
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
  load('helper', 'sendPusher');
}

function indexAction()
{
  $list_users = get_list_users();
  if (isset($_POST["search"])) {
    $list_users = get_list_users_by_search($_POST["search"], $_POST["userRole"], $_POST["userStatus"]);
  }

  $data_list = array();
  foreach ($list_users as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'avatar' => $value['avatar'],
      'fullname' => $value['fullname'],
      'email' => $value['email'],
      'role' => $value['name'],
      'date_created' => date('d-m-Y', strtotime($value['date_created'])),
      'status' => $value['status']
    );
  }

  $item_per_page = 10;
  $current_page = 1;
  if (isset($_POST["page"])) {
    $current_page = $_POST["page"];
  }
  $total_page = ceil(count($data_list) / $item_per_page);
  $offset = ($current_page - 1) * $item_per_page;

  $currentItems = array_slice($data_list, $offset, $item_per_page);

  $data = array(
    'active' => 'user',
    'list_users' => $currentItems,
    'list_roles' => get_role_users(),
    'total_page' => $total_page,
    'current_page' => $current_page,
  );
  load_view('index', $data);
}

function addUserAction()
{
  if (isset($_POST['username']) && isset($_POST["password"]) && isset($_POST["email"])) {
    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/";
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    if (empty($_POST['full_name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['role'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
    } else if (!preg_match($pattern, $_POST['password'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.",
        "notifyType" => "warning",
      ]);
    } else if ($_POST["password"] !== $_POST["repeat_password"]) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu không trùng khớp.",
        "notifyType" => "warning",
      ]);
    } else if (!preg_match($emailPattern, $_POST['email'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Định dang gmail không hợp lệ.",
        "notifyType" => "warning",
      ]);
    } else if (!empty(get_list_users_by_username($_POST["username"]))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Tài khoản đã được sử dụng.",
        "notifyType" => "warning",
      ]);
    } else if (!empty(get_list_users_by_email($_POST["email"]))) {
      echo json_encode([
        "type" => "fail",
        "message" => "Email đã được sử dụng.",
        "notifyType" => "warning",
      ]);
    } else {
      $data_accounts = array(
        'avatar' => 'upload\avatar-default.jpg',
        'username' => $_POST['username'],
        'password' => $_POST["password"],
        'status' => '1',
        'role_id' => $_POST["role"],
      );

      $data_users = array(
        'fullname' => $_POST["full_name"],
        'email' => $_POST["email"],
        'phone_number' => $_POST["phone_number"],
        'birthday' => date('Y-m-d', strtotime($_POST["birthday"])),
        'gender' => $_POST["gender"],
      );

      if (add_user($data_accounts, $data_users)) {
        echo json_encode([
          "type" => "success",
          "message" => "Thêm thành công.",
          "notifyType" => "success"
        ]);
      } else {
        echo json_encode([
          "type" => "fail",
          "message" => "Thêm thất bại.",
          "notifyType" => "danger"
        ]);
      }
    }
    exit();
  }
}

function updateUserAction()
{
  if (isset($_POST['account_id'])) {
    $pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/";
    $emailPattern = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";
    if (empty($_POST['full_name']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['role'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Vui lòng nhập đầy đủ thông tin!",
        "notifyType" => "warning",
      ]);
    } else if (!preg_match($pattern, $_POST['password'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.",
        "notifyType" => "warning",
      ]);
    } else if ($_POST["password"] !== $_POST["repeat_password"]) {
      echo json_encode([
        "type" => "fail",
        "message" => "Mật khẩu không trùng khớp.",
        "notifyType" => "warning",
      ]);
    } else if (!preg_match($emailPattern, $_POST['email'])) {
      echo json_encode([
        "type" => "fail",
        "message" => "Định dang gmail không hợp lệ.",
        "notifyType" => "warning",
      ]);
    } else {
      $data_accounts = array(
        'password' => $_POST["password"],
        'status' => $_POST["status"],
        'role_id' => $_POST["role"],
      );

      $data_users = array(
        'fullname' => $_POST["full_name"],
        'email' => $_POST["email"],
        'phone_number' => $_POST["phone_number"],
        'birthday' => date('Y-m-d', strtotime($_POST["birthday"])),
        'gender' => $_POST["gender"],
      );

      if (update_user_info($_POST['account_id'], $data_accounts, $data_users)) {
        echo json_encode([
          "type" => "success",
          "message" => "Cập nhật thành công.",
          "notifyType" => "success"
        ]);

        if($_POST["status"] == 0) {
          sendPusherEvent("pusher", "user", [
            "id" => $_POST["account_id"],
            "type" => "block",
          ]);
        }
      } else {
        echo json_encode([
          "type" => "fail",
          "message" => "Cập nhật thất bại.",
          "notifyType" => "danger"
        ]);
      }
    }
    exit();
  } else {
    $id = (int) $_GET['id'];
    $roles = get_role_users();
    $user_update = get_user_by_id($id);
    $data_user = array(
      'account_id' => $id,
      'user_info' => $user_update,
      'roles' => $roles,
    );
    load_view('update', $data_user);
  }
}

function deleteUserAction()
{
  $id = (int) $_GET['id'];
  $item = db_fetch_row("SELECT id FROM accounts WHERE `username` = 'unknown'");
  $data = array(
    'user_id' => $item['id'],
  );

  db_update('stations', $data, "`user_id` = '{$id}'");

  // Xóa trong bảng userinfo:
  db_delete('userinfo', "`account_id` = {$id}");

  // Xóa trong bảng accounts:
  db_delete('accounts', "`id` = {$id}");

  header('location: ?mod=users');
}

function blockAction()
{
  if (isset($_POST["account_id"])) {
    if ($_POST["account_id"] == $_SESSION['user_info']["account_id"]) {
      echo "success";
      exit();
    }
  }
}
