<?php

function construct()
{
    load_model('index');
    load('lib', 'validation');
}

function loginAction()
{
    global $error, $username, $password;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $error = array(); // Phất cờ

        if (empty($_POST['username'])) {
            $error['username'] = "Vui lòng nhập username"; // hạ cờ
        } else {
            $username = $_POST['username'];
        }

        if (empty($_POST['password'])) {
            $error['password'] = "Vui lòng nhập password"; // hạ cờ
        } else {
            $password = $_POST['password'];
        }
        // Kết luận
        if (empty($error)) {
            if (check_login($username, $password)) {
                // Lưu trữ phiên login
                $_SESSION['is_login'] = true;
                $_SESSION['user_login'] = $username;

                redirect("?");
            } else {
                $error['account'] = "Tài khoản không tồn tại 😜";
            }
        }
    }
    load_view('login');
}

function logoutAction()
{
    session_destroy();
    redirect("?mod=users&controller=login&action=login");
}
