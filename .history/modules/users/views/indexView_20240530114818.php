<!-- Header -->
<?php require "./layout/header.php" ?>
<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content mt-2">
        <div class="row">
            <h3>Quản lý tài khoản</h3>
        </div>
        <div class="col-md-12">

            <?php
            global $error, $success;
            if (!empty($_SESSION['success'])) {
                $success['success'] = $_SESSION['success'];
                unset($_SESSION['success']); // Xóa thông báo sau khi đã hiển thị
            ?>
                <div id="successToast" class="toast position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;" aria-live="polite" aria-atomic="true">
                    <div class="toast-header text-bg-primary">
                        <span class="mr-4"><i class='bx bxs-bell-ring'></i></span>
                        <strong class="me-auto">Thông báo</strong>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?php if (!empty($success['success'])) echo $success['success']; ?>
                    </div>
                </div>
            <?php
            }
            if (!empty($_SESSION['error'])) {
                $error['error'] = $_SESSION['error'];
                unset($_SESSION['error']); // Xóa thông báo sau khi đã hiển thị
            ?>
                <div id="successToast" class="toast position-fixed top-50 start-50 translate-middle" role="alert" style="z-index: 9999;" aria-live="polite" aria-atomic="true">
                    <div class="toast-header text-bg-danger">
                        <span class="mr-4"><i class='bx bxs-bell-ring'></i></span>
                        <strong class="me-auto">Thông báo</strong>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?php if (!empty($error['error'])) echo $error['error']; ?>
                    </div>
                </div>
            <?php
            }
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Ngày sinh</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Giới tính</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($list_users as $user) {
                        $count++;
                    ?>
                        <tr>
                            <th scope="row"><?php echo $count ?></th>
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['fullname'] ?></td>
                            <td><?php echo $user['birthday'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['phone_number'] ?></td>
                            <td><?php if ($user['gender'] == 1) {
                                    echo 'Nam';
                                } else {
                                    echo 'Nữ';
                                } ?></td>
                            <td><?php echo $user['name'] ?></td>
                            <td>
                                <div class="d-flex">
                                    <a href="?mod=users&action=updateUser&views=update&id=<?php echo $user['account_id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                    <a href="?mod=users&action=deleteUser&id=<?php echo $user['account_id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá tài khoản này?')">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>