<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Cảm biến</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <div class="mb-3">
        <label for="id_sensor" class="col-form-label">Mã cảm biến</label>
        <input type="number" class="form-control bg-transparent" id="id_sensor" value="<?php if (!empty($sensor_update['id'])) echo $sensor_update['id']; ?>" disabled min="1">
      </div>
      <div class="mb-3">
        <label for="name_sensor" class="col-form-label">Tên cảm biến</label>
        <input type="text" class="form-control" id="name_sensor" value="<?php if (!empty($sensor_update['sensor_name'])) echo $sensor_update['sensor_name']; ?>">
      </div>
      <div class="mb-3">
        <label for="station_sensor" class="col-form-label">Trạm</label>
        <select class="form-select" id="station_sensor">
          <option selected hidden>-- Chọn trạm --</option>
          <?php foreach ($list_station as $index => $station) { ?>
            <option value="<?php echo $station['id'] ?>" <?= $sensor_update['station_id'] == $station['id'] ? 'selected' : '' ?>>
              <?php echo $station['name'] ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="position_sensor" class="col-form-label">Tầng</label>
        <input type="number" class="form-control" id="position_sensor" value="<?php echo $sensor_update['position'] ?>" min="1">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
      <button type="submit" class="btn btn-primary" id="update_sensor">Cập nhật</button>
    </div>
  </div>
</div>