<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2 px-2">
        <div class="content w-100 mt-2 px-2">
            <h4 class="m-2">Đơn vị đo</h4>
        </div>

        <div class="row g-0 mb-2">
            <div class="w-auto ms-auto">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addUnitModal" data-bs-whatever="@mdo">
                    <i class='bx bx-add-to-queue'></i> Thêm đơn vị đo
                </button>
            </div>
        </div>

        <table class="table table-hover shadow">
            <thead>
                <tr>
                    <th class="text-center">Mã đơn vị</th>
                    <th class="text-center">Tên đơn vị</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_units as $unit) : ?>
                    <tr>
                        <td class="text-center"><?= $unit['id'] ?></td>
                        <td class="text-center"><?= $unit['name'] ?></td>
                        <td class="text-center d-flex justify-content-center">
                            <a href="?mod=units&action=updateUnit&views=update&id=<?php echo $unit['id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                            <a href="?mod=units&action=deleteUnit&id=<?php echo $unit['id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá đơn vị đo này?')">
                                <i class='bx bx-trash'></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal add Sensor-->
<div class="modal fade" id="addUnitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm đơn vị đo mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="?mod=units&action=addUnit">
                    <div class="mb-3">
                        <label for="unit-name" class="col-form-label">Đơn vị đo</label>
                        <input type="text" class="form-control" id="unit-name" name="unit_name">
                    </div>
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
                        <button type="submit" class="btn btn-primary ms-2" name="add_unit">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<?php require "./layout/footer.php" ?>