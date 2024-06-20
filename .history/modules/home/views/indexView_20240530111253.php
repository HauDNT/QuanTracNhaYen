<!-- Header -->
<?php require "./layout/header.php" ?>
<!-- Content -->
<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content mt-2 px-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <h3>Thống kê</h3>
                </div>

                <div class="d-flex">
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
        </div>
        <!-- Chart -->
        <div class="row chart-wrapper">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bd/Pushkin_population_history.svg/1200px-Pushkin_population_history.svg.png" alt="">
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>