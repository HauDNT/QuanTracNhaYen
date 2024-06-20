<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2">
        <div class="row g-0 mb-2">


            <div class="d-flex mb-2">
                <select class="form-select w-auto me-2" style="cursor: pointer" aria-label="Default select example">
                    <option selected disabled hidden>Vị trí</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

                <select class="form-select w-auto me-2" style="cursor: pointer" aria-label="Default select example">
                    <option value="1">Nhiệt độ</option>
                    <option value="2">Độ ẩm</option>
                </select>

                <select class="form-select w-auto" style="cursor: pointer" aria-label="Default select example">
                    <option value="1">Năm</option>
                    <option value="2" selected>Tháng</option>
                    <option value="3">Ngày</option>
                </select>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" class="text-center">STT</th>
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
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>