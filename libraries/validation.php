<?php 

function is_username($username) {
    $pattern = "/^[A-Za-z0-9_\.]{6,32}$/"; 
    if (!preg_match($pattern, $username, $matches))
        return false;
    return true;
}

function is_password($password) {
    $pattern = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
    if (!preg_match($pattern, $password, $matches)) 
        return false;
    return true;
}

function is_email($email) {
    $pattern = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
    if (!preg_match($pattern, $email, $matches))
        return false;
    return true;
}

function form_error($label_field) {
    global $error;
    if (!empty($error[$label_field]))
        return $error[$label_field];
}

function set_value($label_field) {
    global $$label_field;
    if (!empty($$label_field)) 
        return $$label_field;
}

?>