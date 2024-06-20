<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2 px-2">
        <div class="row g-0 mb-2">
            <h4 class="m-2 ms-3">Cảm biến</h4>
        </div>

        <div class="row g-0 mb-2">
            <div class="input-group w-auto">
                <input class="search form-control" type="search" placeholder="Tìm cảm biến..." aria-label="Search">
                <button class="search-btn btn text-bg-info"><i class="bi bi-search"></i></button>
            </div>
            <div class="w-auto ms-auto">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addSensorModal" data-bs-whatever="@mdo">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

        <table class="table table-hover shadow-sm">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Mã cảm biến</th>
                    <th class="text-center">Tên cảm biến</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_sensor as $index => $sensor) : ?>
                    <tr>
                        <th class="text-center"><?= $index + 1 ?></th>
                        <td class="text-center"><?= $sensor['id'] ?></td>
                        <td class="text-center"><?= $sensor['name'] ?></td>
                        <td class="text-center"><?= $sensor['connect_status'] == 0 ? "Chưa kết nối" : "Đã kết nối" ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="?mod=sensors&action=updateSensor&views=update&id=<?= $sensor['id'] ?>" class="text-light btn btn-warning me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=sensors&action=deleteSensor&id=<?= $sensor['id'] ?>" class="btn btn-danger btn-xs sharp" onclick="return confirm('Bạn muốn xoá cảm biến này?')">
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