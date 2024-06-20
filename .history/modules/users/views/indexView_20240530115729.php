<!-- Header -->
<?php require "./layout/header.php" ?>
<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2">
        <div class="row g-0 mb-2">
            <h3>Quản lý tài khoản</h3>
        </div>

        <div class="row g-0 mb-2">
            <button type="button" class="btn w-auto ms-auto btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" data-bs-whatever="@mdo">
                <a href="?mod=users&action=addUser&views=add" class="text-white text-decoration-none">
                    <i class='bx bx-add-to-queue'></i> Thêm tài khoản
                </a>
            </button>
        </div>

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
                    <th class="text-center">#</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Họ tên</th>
                    <th class="text-center">Ngày sinh</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Số điện thoại</th>
                    <th class="text-center">Giới tính</th>
                    <th class="text-center">Vai trò</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_users as $index => $user) : ?>
                    <tr>
                        <th class="text-center"><?= $index + 1 ?></th>
                        <td class="text-center"><?= $user['username'] ?></td>
                        <td class="text-center"><?= $user['fullname'] ?></td>
                        <td class="text-center"><?= $user['birthday'] ?></td>
                        <td class="text-center"><?= $user['email'] ?></td>
                        <td class="text-center"><?= $user['phone_number'] ?></td>
                        <td class="text-center"><?= $user['gender'] == 1 ? "Name" : "Nữ" ?></td>
                        <td><?= $user['name'] ?></td>
                        <td class="d-flex justif">
                                <a href="?mod=users&action=updateUser&views=update&id=<?= $user['account_id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=users&action=deleteUser&id=<?= $user['account_id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá tài khoản này?')">
                                    <i class='bx bx-trash'></i>
                                </a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>