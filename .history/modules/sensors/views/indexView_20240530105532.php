<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="container-fluid mainpage mt-3">
    <div class="row">
        <div class="col-sm-12 pb-3">
            <div class="row d-flex align-items-center">
                <h3 class="w-auto">Cảm biến</h3>
                <div class="w-auto ms-auto">
                    <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addSensorModal" data-bs-whatever="@mdo">
                        <i class='bx bx-add-to-queue'></i> Thêm cảm biến
                    </button>
                </div>
            </div>
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
                        <th scope="col">Tên cảm biến</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($list_sensor as $sensor) {
                        $count++;
                    ?>
                        <tr>
                            <th scope="row"><?php echo $count ?></th>
                            <td><?php echo $sensor['name'] ?></td>
                            <td><?php echo $sensor['connect_status'] == 0 ? "Chưa kết nối" : "Đã kết nối" ?></td>
                            <td>
                                <div class="d-flex">
                                    <a href="?mod=sensors&action=updateSensor&views=update&id=<?php echo $sensor['id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                    <a href="?mod=sensors&action=deleteSensor&id=<?php echo $sensor['id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá cảm biến này?')">
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

<section class="overlay"></section>

<!-- Modal add Sensor-->
<div class="modal fade" id="addSensorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm cảm biến</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="?mod=sensors&action=addSensor">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tên cảm biến</label>
                        <input type="text" class="form-control" id="recipient-name" name="name_sensor">
                    </div>
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
                        <button type="submit" class="btn btn-primary ms-2" name="add_sensor">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>