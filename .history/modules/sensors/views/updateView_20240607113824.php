<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Cảm biến</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Mã cảm biến</label>
                <input type="number" class="form-control" id="recipient-name" name="id_sensor" value="<?php if (!empty($sensor_update['id'])) echo $sensor_update['id']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Tên cảm biến</label>
                <input type="text" class="form-control" id="recipient-name" name="name_sensor" value="<?php if (!empty($sensor_update['sensor_name'])) echo $sensor_update['sensor_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Trạm</label>
                <select class="form-select" name="station_sensor">
                    <option selected hidden>-- Chọn trạm --</option>
                    <?php foreach ($list_station as $index => $station) { ?>
                        <option value="<?php echo $station['id'] ?>" <?php
                                                                        if ($sensor_update['station_id'] == $station['id'])
                                                                            echo 'selected'
                                                                        ?>>
                            <?php echo $station['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Tầng</label>
                <input type="number" class="form-control" id="recipient-name" name="position_sensor" value="<?php echo $sensor_update['position'] ?>" min="1">
            </div>
        </div>
        <div class="mb3 mt-8 d-flex modal-footer">
            <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal"><a href="?mod=sensors" class="text-light text-decoration-none">Trở lại</a></button>
            <button type="submit" class="btn btn-primary ms-2" name="update_sensor">Cập nhật</button>
        </div>
    </div>
</div>