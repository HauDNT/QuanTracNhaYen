<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content mt-2">
                <div class="row">
                    <h3>Báo cáo</h3>
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
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>