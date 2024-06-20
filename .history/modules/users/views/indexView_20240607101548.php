<!-- Header -->
<?php require "./layout/header.php" ?>
<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2 px-2">
        <div class="row g-0 mb-2">
            <h4 class="m-2 ms-3">Quản lý tài khoản</h4>
        </div>

        <div class="row g-0 mb-2">
            <div class="input-group w-auto">
                <input class="search form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                <button class="search-btn btn text-bg-primary"><i class="bi bi-search"></i></button>
            </div>
            <button type="button" class="btn w-auto ms-auto btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" data-bs-whatever="@mdo">
                <a href="?mod=users&action=addUser&views=add" class="text-white text-decoration-none">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </button>
        </div>

        <table class="table table-hover shadow-sm rounded-3 overflow-hidden p-3">
            <thead>
                <tr>
                    <th class="text-center">#</th>
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
                        <td class="text-center text-break"><?= $user['fullname'] ?></td>
                        <td class="text-center"><?= $user['birthday'] ?></td>
                        <td class="text-center"><?= $user['email'] ?></td>
                        <td class="text-center"><?= $user['phone_number'] ?></td>
                        <td class="text-center"><?= $user['gender'] == 1 ? "Nam" : "Nữ" ?></td>
                        <td><?= $user['name'] ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="?mod=users&action=updateUser&views=update&id=<?= $user['account_id'] ?>" class="text-light btn btn-warning me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=users&action=deleteUser&id=<?= $user['account_id'] ?>" class="btn btn-danger btn-xs sharp" onclick="return confirm('Bạn muốn xoá tài khoản này?')">
                                    <i class='bx bx-trash'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>