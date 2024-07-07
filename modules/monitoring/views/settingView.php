<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
  <div class="modal-content" value="<?= $id ?>">
    <div class="modal-header">
      <h1 class="modal-title fs-5 me-2" id="exampleModalLabel">Thiết lập trạm</h1>
      <?php if (count($position_list) > 0) : ?>
        <select class="form-select w-auto" id="position" aria-label="Default select example">
          <?php foreach ($position_list as $position) : ?>
            <option value="<?= $position["position"] ?>" <?= $position["position"] == $position_choose ? "selected" : "" ?> >Tầng <?= $position["position"] ?></option>
          <?php endforeach; ?>
        </select>
      <?php endif; ?>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body overflow-y-scroll">
      <div class="mb-3">
        <div class="form-check form-switch form-check-reverse text-start d-flex align-items-center justify-content-between">
          <label for="time-start" class="col-form-label fw-semibold">Thời gian phun sương</label>
          <input data="<?= $sensor_setting["sensor_id"] ?>" class="form-check-input" type="checkbox" role="switch" id="turn_mist_spray" <?= $sensor_setting["motor_status"] == 0 ? "" : "checked" ?>>
        </div>
        <div class="d-flex align-items-center">
          <label for="time-start" class="text-nowrap me-2">Từ</label>
          <div class="input-group">
            <input type="text" class="form-control border-end-0" id="time-start" value="<?= date('H:i', strtotime($sensor_setting["time_start"])) ?>">
            <label for="time-start" class="input-group-text bg-transparent text-primary"><i class="bi bi-clock"></i></label>
          </div>

          <label for="time-finish" class="text-nowrap mx-2">đến</label>
          <div class="input-group">
            <input type="text" class="form-control border-end-0" id="time-finish" value="<?= date('H:i', strtotime($sensor_setting["time_finish"])) ?>">
            <label for="time-finish" class="input-group-text bg-transparent text-primary"><i class="bi bi-clock"></i></label>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="temp_thres_min" class="col-form-label fw-semibold">Ngưỡng nhiệt độ</label>
        <div class="d-flex align-items-center">
          <label for="temp_thres_min_range" class="text-nowrap me-2">Từ</label>
          <input type="range" class="form-range me-2" id="temp_thres_min_range" value="<?= $sensor_setting["temp_thres_min"] ?>" min="0" max="100">
          <input type="number" class="form-control" id="temp_thres_min" value="<?= $sensor_setting["temp_thres_min"] ?>" min="0" max="100">

          <label for="temp_thres_max_range" class="text-nowrap mx-2">đến</label>
          <input type="range" class="form-range me-2" id="temp_thres_max_range" value="<?= $sensor_setting["temp_thres_max"] ?>" min="0" max="100">
          <input type="number" class="form-control" id="temp_thres_max" value="<?= $sensor_setting["temp_thres_max"] ?>" min="0" max="100">
        </div>
      </div>

      <div class="mb-3">
        <label for="humid_thres_min" class="col-form-label fw-semibold">Ngưỡng độ ẩm</label>
        <div class="d-flex align-items-center">
          <label for="humid_thres_min_range" class="text-nowrap me-2">Từ</label>
          <input type="range" class="form-range me-2" id="humid_thres_min_range" value="<?= $sensor_setting["humid_thres_min"] ?>" min="0" max="100">
          <input type="number" class="form-control" id="humid_thres_min" value="<?= $sensor_setting["humid_thres_min"] ?>" min="0" max="100">

          <label for="humid_thres_max_range" class="text-nowrap mx-2">đến</label>
          <input type="range" class="form-range me-2" id="humid_thres_max_range" value="<?= $sensor_setting["humid_thres_max"] ?>" min="0" max="100">
          <input type="number" class="form-control" id="humid_thres_max" value="<?= $sensor_setting["humid_thres_max"] ?>" min="0" max="100">
        </div>
      </div>

      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="send_data" class="col-form-label">Thời gian gửi dữ liệu</label>
          <div class="input-group">
            <input type="number" class="form-control border-end-0" id="send_data" value="<?= $sensor_setting["time_send_data"] ?>">
            <label for="send_data" class="input-group-text bg-transparent">phút</label>
          </div>
        </div>
        <div class=" flex-sm-fill mb-3">
          <label for="send_email" class="col-form-label">Thời gian gửi email</label>
          <div class="input-group">
            <input type="number" class="form-control border-end-0" id="send_email" value="<?= $email_setting["timeSendEmail"] ?>">
            <label for="send_email" class="input-group-text bg-transparent">phút</label>
          </div>
        </div>
      </div>

      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="email" class="col-form-label">Email gửi <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" value="<?= $email_setting["sender_email"] ?>">
        </div>
        <div class="flex-sm-fill mb-3">
          <label for="password" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="password" class="form-control border-end-0" id="password" value="<?= $email_setting["sender_password"] ?>">
            <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
      <button value="<?= $sensor_setting["sensor_id"] ?>" type="button" class="btn btn-primary" id="setting_station_save">Lưu</button>
    </div>
  </div>
</div>