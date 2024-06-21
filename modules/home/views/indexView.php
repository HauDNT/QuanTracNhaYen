<!-- Header -->
<?php require "./layout/header.php" ?>

<!-- Content -->
<div id="main-page" class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>

    <div class="content w-100 mt-2 px-2">
        <div class="row g-0 mb-2">
            <h3 class="col-md-12 col-sm-12">Giám sát</h3>
            <div class="col-md-6 col-sm-12">
                <!-- Biểu đồ -->
                <canvas id="chart_1"></canvas>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div id="map" class="mb-3 p-10 map-home"></div>
                </div>
                <div class="row">
                    <table id="table-pos-station" class="table">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Tầng</th>
                                <th scope="col">Nhiệt độ</th>
                                <th scope="col">Độ ẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td colspan="3">Không có dữ liệu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>