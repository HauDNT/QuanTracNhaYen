<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-fluid d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2 px-2">
        <div class="row g-0 mb-2">
            <h4 class="m-2 ms-3">Trạm quan sát</h4>
        </div>

        <div class="row g-0 mb-2">
            <div class="input-group w-auto">
                <label for="search" class="text-secondary bg-white border border-end-0 rounded-start-pill text-center py-2 ps-3 pe-1"><i class="bi bi-search"></i></label>
                <input class="search ps-1 form-control border-start-0 rounded-end-pill" type="search" placeholder="Tìm kiếm..." aria-label="Search">
            </div>
            <div class="w-auto ms-auto">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addStationModal" data-bs-whatever="@mdo">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

        <table class="table table-hover shadow-sm rounded-3 overflow-hidden">
            <thead>
                <tr>
                    <th scope="col" class="text-bg-primary">#</th>
                    <th scope="col" class="text-bg-primary">Trạm</th>
                    <th scope="col" class="text-bg-primary">Tung độ</th>
                    <th scope="col" class="text-bg-primary">Hoành độ</th>
                    <th scope="col" class="text-bg-primary">Địa chỉ Web Server</th>
                    <th scope="col" class="text-bg-primary">Người quản lý</th>
                    <th scope="col" class="text-bg-primary">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_station_info as $index => $station) : ?>
                    <tr>
                        <th class="text-center"><?= $index + 1 ?></th>
                        <td><?php echo $station['name'] ?></td>
                        <td><?php echo $station['longtitude'] ?></td>
                        <td><?php echo $station['langtitude'] ?></td>
                        <td>
                            <a href="http://<?php echo $station['urlServer'] ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo $station['urlServer'] ?>
                            </a>
                        </td>
                        <td><?php echo $station['fullname'] ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="?mod=stations&action=updateStation&views=update&id=<?php echo $station['id'] ?>" class="text-light btn btn-warning me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=stations&action=deleteStation&id=<?php echo $station['id'] ?>" class="btn btn-danger btn-xs sharp" onclick="return confirm('Bạn muốn xoá thông tin trạm này?')">
                                    <i class='bx bx-trash'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal add Station-->
    <div class="modal fade" id="addStationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm trạm mới</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="station-name" class="col-form-label">Tên trạm</label>
                        <input type="text" class="form-control" id="station-name">
                    </div>
                    <div id="map" class="mb-3"></div>
                    <div class="mb-3">
                        <label for="station-longtitude" class="col-form-label">Kinh độ</label>
                        <input type="text" class="form-control" id="station-longtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Vĩ độ</label>
                        <input type="text" class="form-control" id="station-langtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Địa chỉ DDNS URL</label>
                        <input type="text" class="form-control" id="station-langtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Chi tiết</label>
                        <input type="text" class="form-control" id="station-langtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station_user" class="col-form-label">Người quản lý</label>
                        <select class="form-select" aria-label="Default select example" id="station_user">
                            <option selected hidden>-- Chọn người quản lý trạm --</option>
                            <?php foreach ($list_user_info as $user) : ?>
                                <option value="<?= $user['account_id'] ?>"><?= $user['fullname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
                    <button type="button" class="btn btn-primary" id="add_station">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>