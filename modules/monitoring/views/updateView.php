<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật trạm</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body overflow-y-scroll">
      <div class="mb-3">
        <label for="station-name" class="col-form-label">Tên trạm <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="station-name" value="<?= $station_update['name'] ?>">
      </div>
      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="station-longitude" class="col-form-label">Kinh độ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="station-longitude" value="<?= $station_update['longtitude'] ?>">
        </div>
        <div class="flex-sm-fill mb-3">
          <label for="station-latitude" class="col-form-label">Vĩ độ <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="station-latitude" value="<?= $station_update['langtitude'] ?>">
        </div>
      </div>
      <div class="mb-3">
        <label for="station-url" class="col-form-label">Địa chỉ DDNS URL</label>
        <input type="text" class="form-control" id="station-url" value="<?= $station_update['urlServer'] ?>">
      </div>
      <div class="mb-3">
        <label for="station_user" class="col-form-label">Người quản lý <span class="text-danger">*</span></label>
        <select class="form-select" aria-label="Default select example" id="station_user">
          <option selected hidden>-- Chọn người quản lý trạm --</option>
          <?php foreach ($list_user_info as $user) : ?>
            <option value="<?= $user['account_id'] ?>" <?= $station_update['user_id'] == $user['account_id'] ? "selected" : "" ?> ><?= $user['fullname'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
      <button value="<?= $station_update['id'] ?>" type="button" class="btn btn-primary" id="update_station">Cập nhật</button>
    </div>
  </div>
</div>