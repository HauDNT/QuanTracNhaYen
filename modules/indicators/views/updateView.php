<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa chỉ số</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body overflow-y-scroll pe-2">
      <div class="mb-3">
        <label for="indicator-name" class="col-form-label">Tên chỉ số</label>
        <input type="text" class="form-control" id="indicator_name" value="<?= $indicator_update["name"] ?>">
      </div>
      <div class="mb-3">
        <label for="indicator_unit" class="col-form-label">đơn vị</label>
        <input type="text" class="form-control" id="indicator_unit" value="<?= $indicator_update["unit"] ?>">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
      <button type="button" class="btn btn-primary ms-2" id="update_indicator" value="<?= $indicator_update["id"] ?>">Cập nhật</button>
    </div>
  </div>
</div>