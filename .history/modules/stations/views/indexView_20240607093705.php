<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="main-page container-xxl d-flex p-0">
    <?php require "./layout/sidebar.php" ?>
    <div class="content w-100 mt-2 px-2">
        <div class="row g-0 mb-2">
            <h4 class="m-2">Trạm quan sát</h4>
        </div>

        <div class="row g-0 mb-2">
            <div class="w-auto ms-auto">
                <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addStationModal" data-bs-whatever="@mdo">
                    <i class='bx bx-add-to-queue'></i> Thêm trạm mới
                </button>
            </div>
        </div>

        <table class="table table-hover shadow">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Trạm</th>
                    <th scope="col">Tung độ</th>
                    <th scope="col">Hoành độ</th>
                    <th scope="col">Địa chỉ DDNS</th>
                    <th scope="col">Chi tiết</th>
                    <th scope="col">Người quản lý</th>
                    <th scope="col">Hành động</th>
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
                        <td><?php echo $station['detail'] ?></td>
                        <td><?php echo $station['fullname'] ?></td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="?mod=stations&action=updateStation&views=update&id=<?php echo $station['id'] ?>" class="text-light btn btn-warning shadow me-3 btn-xs sharp"><i class='bx bx-edit-alt h-1'></i></a>
                                <a href="?mod=stations&action=deleteStation&id=<?php echo $station['id'] ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Bạn muốn xoá thông tin trạm này?')">
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

<!-- Modal add Station-->
<div class="modal fade" id="addStationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm trạm mới</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="?mod=stations&action=addStation">
                    <div class="mb-3">
                        <label for="station-name" class="col-form-label">Tên trạm</label>
                        <input type="text" class="form-control" id="station-name" name="station_name">
                    </div>
                    <div id="map" class="mb-3"></div>
                    <div class="mb-3">
                        <label for="station-longtitude" class="col-form-label">Kinh độ</label>
                        <input type="text" class="form-control" id="station-longtitude" name="station_longtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Vĩ độ</label>
                        <input type="text" class="form-control" id="station-langtitude" name="station_langtitude">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Địa chỉ DDNS URL</label>
                        <input type="text" class="form-control" id="station-langtitude" name="station_urlServer">
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Chi tiết</label>
                        <input type="text" class="form-control" id="station-langtitude" name="station_detail">
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Người quản lý</label>
                        <select class="form-select" aria-label="Default select example" name="station_user">
                            <option selected hidden>-- Chọn người quản lý trạm --</option>
                            <?php foreach ($list_user_info as $user) { ?>
                                <option value="<?php echo $user['account_id'] ?>"><?php echo $user['fullname'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
                        <button type="submit" class="btn btn-primary ms-2" name="add_station">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>