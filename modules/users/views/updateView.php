<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật thông tin người dùng</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body overflow-y-scroll pe-2">
      <div class="mb-3">
        <label for="full_name" class="col-form-label">Họ tên <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="full_name" value="<?= $user_info["fullname"] ?>">
      </div>
      <div class="mb-3">
        <label for="username" class="col-form-label">Tài khoản <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" value="<?= $user_info["username"] ?>" disabled>
      </div>
      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="password" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="password" class="form-control border-end-0" id="password" value="<?= $user_info["password"] ?>">
            <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
          </div>
        </div>
        <div class="flex-sm-fill mb-3">
          <label for="repeat_password" class="col-form-label">Xác nhận mật khẩu</label>
          <div class="input-group">
            <input type="password" class="form-control border-end-0" id="repeat_password" value="<?= $user_info["password"] ?>">
            <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
          </div>
        </div>
      </div>
      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control" id="email" value="<?= $user_info["email"] ?>">
        </div>
        <div class="flex-sm-fill mb-3">
          <label for="phone_number" class="col-form-label">Số điện thoại</label>
          <input type="text" class="form-control" id="phone_number" value="<?= $user_info["phone_number"] ?>">
        </div>
      </div>
      <div class="d-sm-flex">
        <div class="me-sm-2 flex-sm-fill mb-3">
          <label for="birthday-update" class="col-form-label">Ngày sinh</label>
          <div class="input-group">
            <input type="text" class="form-control border-end-0" id="birthday-update" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime($user_info["birthday"])) ?>">
            <label for="birthday-update" class="input-group-text bg-transparent text-primary"><i class="bi bi-calendar3"></i></label>
          </div>
        </div>
        <div class="flex-sm-fill mb-3">
          <label for="gender" class="col-form-label">Giới tính</label>
          <select class="form-select" id="gender" aria-label="Default select example">
            <option value="1" <?= $user_info["gender"] == 1 ? "selected" : "" ?> >Nam</option>
            <option value="0" <?= $user_info["gender"] == 0 ? "selected" : "" ?> >Nữ</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label for="role" class="col-form-label">Quyền <span class="text-danger">*</span></label>
        <select class="form-select" id="role" aria-label="Default select example">
          <option selected hidden disabled>-- Chọn quyền --</option>
          <?php foreach ($roles as $item) : ?>
            <option value="<?= $item['id'] ?>" <?= $user_info["role_id"] == $item['id'] ? "selected" : "" ?> ><?= $item['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
          <label for="status" class="col-form-label">Trạng thái</label>
          <select class="form-select" id="status" aria-label="Default select example">
            <option value="1" <?= $user_info["status"] == 1 ? "selected" : "" ?> >Hoạt động</option>
            <option value="0" <?= $user_info["status"] == 0 ? "selected" : "" ?> >Khóa</option>
          </select>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
      <button type="button" class="btn btn-primary" id="update_user" value="<?= $user_info["id"] ?>">Cập nhật</button>
    </div>
  </div>
</div>