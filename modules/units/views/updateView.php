<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa đơn vị</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body overflow-y-scroll pe-2">
      <div class="mb-3">
        <label for="unit-name" class="col-form-label">Tên đơn vị</label>
        <input type="text" class="form-control" id="unit_name" value="<?= $unit_update["name"] ?>">
      </div>
      <div class="mb-3">
        <label for="unit_symbol" class="col-form-label">Ký hiệu</label>
        <input type="text" class="form-control" id="unit_symbol" value="<?= $unit_update["symbol"] ?>">
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
      <button type="button" class="btn btn-primary ms-2" id="update_unit" value="<?= $unit_update["id"] ?>">Cập nhật</button>
    </div>
  </div>
</div>