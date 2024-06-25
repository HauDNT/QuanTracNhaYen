<?php

function construct()
{
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  load('helper', 'format');
  $list_users = get_list_users();
  if (isset($_POST["search"])) {
    $list_users = get_list_users_by_name($_POST["search"]);
  }
  $data = array(
    'active' => 'user',
    'list_users' => $list_users,
  );
  load_view('index', $data);
}

function addUserAction()
{
  if (isset($_POST['add_user'])) {
    if (
      empty($_POST['fullname']) ||
      empty($_POST['username']) ||
      empty($_POST['email']) ||
      empty($_POST['phone_number']) ||
      empty($_POST['birthday']) ||
      empty($_POST['gender']) ||
      empty($_POST['role']) ||
      empty($_POST['password'])
    ) {
      $_SESSION['error'] = "<b>THÊM THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
    } else {
      $fullname = $_POST['fullname'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $phone_number = $_POST['phone_number'];
      $birthday = $_POST['birthday'];
      $gender = $_POST['gender'];
      $role = $_POST['role'];
      $password = $_POST['password'];
    }

    if (empty($_SESSION['error'])) {
      $data_accounts = array(
        'username' => $username,
        'role_id' => $role,
        'password' => $password,
      );

      $id_user = db_insert('accounts', $data_accounts);

      $data_userinfo = array(
        'fullname' => $fullname,
        'email' => $email,
        'phone_number' => $phone_number,
        'birthday' => $birthday,
        'gender' => $gender,
        'account_id' => $id_user,
      );

      db_insert('userinfo', $data_userinfo);

      $_SESSION['success'] = 'Thêm người dùng <b>THÀNH CÔNG!</b>';
    }
    header('location: ?mod=users');
  }
  $roles = get_role_users();
  $data = array(
    'roles' => $roles,
  );
  load_view('add', $data);
}

function updateUserAction()
{
  if (isset($_POST['update_user'])) {
    $id = (int) $_GET['id'];
    show_array($_POST['update_user']);
    if (empty($_POST['fullname'] ||
      $_POST['username'] ||
      $_POST['email'] ||
      $_POST['phone_number'] ||
      $_POST['birthday'] ||
      $_POST['gender'])) {
      $_SESSION['error'] = "<b>CẬP NHẬT THẤT BẠI</b> vui lòng nhập hết các trường dữ liệu!";
    } else {
      $fullname = $_POST['fullname'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $phone_number = $_POST['phone_number'];
      $birthday = $_POST['birthday'];
      $gender = $_POST['gender'];
      $role_id = $_POST['role'];

      if (empty($_SESSION['error'])) {
        // Cập nhật thông tin user:
        $data_user = array(
          'fullname' => $fullname,
          'email' => $email,
          'phone_number' => $phone_number,
          'birthday' => $birthday,
          'gender' => $gender,
        );
        $data_account = array(
          'username' => $username,
          'role_id' => $role_id,
        );
        update_user($id, $data_user);
        update_account($id, $data_account);

        $_SESSION['success'] = 'Cập nhật thông tin người dùng <b>THÀNH CÔNG!</b>';
      }
    }
    header('location: ?mod=users');
  } else {
    $id = (int) $_GET['id'];
    $roles = get_role_users();
    $user_update = get_user_by_id($id);
    $data_user = array(
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
