<!-- Header -->
<?php require "./layout/header.php" ?>

<!-- Modal update Station-->
<div class="modal fade" id="updateStationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật thông tin trạm</h1>
                <button type="button" class="btn ms-auto" data-bs-dismiss="modal" aria-label="Close">
                <a href="?mod=stations" class="text-light text-decoration-none btn-close"></a>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <input type="hidden" id="sensor-id" name="sensor_id">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tên trạm</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update-recipient-name" 
                            name="station_name" 
                            value="<?php if (!empty($station_update['name'])) echo $station_update['name'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-longtitude" class="col-form-label">Kinh độ</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-longtitude" 
                            name="station_longtitude"
                            value="<?php if (!empty($station_update['longtitude'])) echo $station_update['longtitude'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Vĩ độ</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="station_langtitude"
                            value="<?php if (!empty($station_update['langtitude'])) echo $station_update['langtitude'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Chọn địa điểm</label>
                        <div id="map"></div>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Thêm cảm biến</label>
                        <select class="form-select" name="station_sensors[]" multiple aria-label="Default select example">
                            <option selected hidden>-- Chọn cảm biến --</option>
                            <?php foreach ($list_sensors_unconnect as $sensor) { ?>
                                <option value="<?php echo $sensor['id'] ?>" <?php echo $sensor['connect_status'] == 0 ? "style='color: green'" : "style='color: red' disabled" ?>><?php echo $sensor['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Địa chỉ DDNS URL</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="station_urlServer"
                            value="<?php if (!empty($station_update['urlServer'])) echo $station_update['urlServer'];?>"
                        >
                    </div>

                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Người quản lý</label>
                        <select class="form-select" aria-label="Default select example" name="station_user">
                            <option selected hidden>-- Chọn người quản lý trạm --</option>
                            <?php foreach ($list_user_info as $user) { ?>
                                <option value="<?php echo $user['account_id'] ?>" <?php if ($station_update['user_id'] == $user['account_id']) echo 'selected'?>> <?php echo $user['fullname'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal"><a href="?mod=stations" class="text-light text-decoration-none">Trở lại</a></button>
                        <button type="submit" class="btn btn-primary ms-2" name="update_station">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal JS Script -->
<script type="text/javascript">
    window.onload = () => {
        $('#updateStationModal').modal('show');
    }
</script>

<!-- Footer -->
<?php require "./layout/footer.php" ?>