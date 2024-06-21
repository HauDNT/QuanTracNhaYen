<?php 

// Kiểm tra login
function is_login() {
    if (isset($_SESSION['is_login'])) {
        return true;
    }
    return false;
}

// Trả về user của người login
function user_login() {
    if (!empty($_SESSION['user_login'])) {
        return $_SESSION['user_login'];
    }
    return false;
}

// Lấy thông tin user đăng nhập
function info_user($field = "id") {
    global $users;
    if (is_login()) {
        foreach ($users as $user) {
            if (user_login() == $user['username']) {
                if (array_key_exists($field, $user)) {
                    return $user[$field];
                }
            }
        }
    }
    return false;
}
?>