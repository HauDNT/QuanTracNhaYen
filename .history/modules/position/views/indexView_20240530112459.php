<!-- Header -->
<?php require "./layout/header.php" ?>
<!-- Content -->
<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content mt-2">
        <div class="row g-0">
            <h3>Tầng</h3>
            <div class="w-auto ms-auto">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addPositionModal" data-bs-whatever="@mdo">
                    <i class='bx bx-add-to-queue'></i> Thêm Tầng
                </button>
            </div>
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

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Hành động</th>
                    <th scope="col" class="text-center">Tên cảm biến</th>
                    <th scope="col" class="text-center">Trạm</th>
                    <th scope="col" class="text-center">Tầng</th>
                    <th scope="col" class="text-center">Giá trị</th>
                    <th scope="col" class="text-center">Đơn vị</th>
                    <th scope="col" class="text-center">Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report as $index => $value) : ?>
                    <tr>
                        <th class="text-center"><?= $index + 1 ?></th>
                        <td class="text-center"><?= $value["sensorsName"] ?></td>
                        <td class="text-center"><?= $value["stationName"] ?></td>
                        <td class="text-center"><?= $value["Position"] ?></td>
                        <td class="text-center"><?= $value["value"] ?></td>
                        <td class="text-center"><?= $value["unit"] ?></td>
                        <td class="text-center"><?= $value["createdAt"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tầng</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                foreach ($list_position as $position) {
                    $count++;
                ?>
                    <tr>
                        <th scope="row"><?php echo $count ?></th>
                        <td><?php echo $position['Position'] ?></td>
                        <td>
                            <div class="d-flex">
                                <a href="?mod=position&action=updatePosition&views=update&id=<?php echo $position['id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=position&action=deletePosition&id=<?php echo $position['id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá tầng này?')">
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

<!-- Modal add Sensor-->
<div class="modal fade" id="addPositionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Tầng</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="?mod=position&action=addPosition">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tầng</label>
                        <input type="text" class="form-control" id="recipient-name" name="name_position">
                    </div>
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
                        <button type="submit" class="btn btn-primary ms-2" name="add_position">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>