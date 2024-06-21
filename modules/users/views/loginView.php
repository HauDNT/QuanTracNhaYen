<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <!-- FAVICONS ICON -->

        <!-- CSS -->
        <link href="./public/css/styles-login.css" rel="stylesheet">

        <style>
            @media (min-width: 768px) {
                .width-login {
                    width: 36%;
                }
            }
        </style>
    </head>
    <body class="min-vh-100">
        <div class="authincation h-100">
            <div class="container h-100 width-form">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-6 width-login">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-3" style="width: 160px; margin-left: auto; margin-right: auto;">
                                            <img src="./public/img/logoKGU.png" alt="Mtop" class="logo-full" style="width: 100%;">
                                        </div>
                                        <h4 class="text-center pb-3 message-error">
                                            <?php if(!empty(form_error('account')))echo form_error('account'); ?>
                                        </h4>
                                        <form action="" method="POST">
                                            <div class="mb-3">
                                                <label class="mb-1 label-login"><strong>Tên tài khoản</strong></label>
                                                <input 
                                                    type="username" name="username" 
                                                    class="form-control" 
                                                    placeholder="nguyenvana" 
                                                    value="<?php if (!empty($_POST['username'])) echo $_POST['username'] ?>"
                                                >
                                                <span class="message-error"><?php echo form_error('username'); ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="mb-1 label-login"><strong>Mật khẩu</strong></label>
                                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                                                <span class="message-error"><?php echo form_error('password'); ?></span>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" name="login" class="btn btn-primary btn-block btn-login">
                                                    Đăng nhập
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>