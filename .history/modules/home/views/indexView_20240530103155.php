<!-- Header -->
<?php require "./layout/header.php" ?>
<!-- Content -->
<div class="main-page">
    <div class="container-xxl">
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

                <!-- Cards -->
                <div class="row card-wrapper mx-1">
                    <div class="card col-sm-2">
                        <div class="card-body">
                            <div class="card-heading">
                                <div class="col-2">
                                    <i class="bx bxs-certification icon"></i>
                                </div>
                                <div class="col">
                                    <h5 class="card-title">Nhiệt độ, độ ẩm</h5>
                                    <h6 class="card-subtitle mb-2 active">Đang hoạt động</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-sm-2">
                        <div class="card-body">
                            <div class="card-heading">
                                <div class="col-2">
                                    <i class="bx bxs-hot icon"></i>
                                </div>
                                <div class="col">
                                    <h5 class="card-title">Báo cháy</h5>
                                    <h6 class="card-subtitle mb-2 unactive">Không kết nối</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="row chart-wrapper col-sm-12">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bd/Pushkin_population_history.svg/1200px-Pushkin_population_history.svg.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>