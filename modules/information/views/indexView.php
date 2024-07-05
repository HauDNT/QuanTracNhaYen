<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar-setting.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0">
    <ul id="tab-sensor" class="nav nav-tabs border-0">
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "information"  ? "active" : "" ?>" href="?mod=users">Cá nhân</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column rounded-end-3 rounded-bottom-3">
    <div class="row g-0 bg-white p-3 pb-2 mt-2">
      <div id="user-avatar" class="col-12 col-sm-2 mb-2">
        <div class="position-relative d-inline-block">
          <img class="rounded-circle" src="" alt="" width="64px" height="64px">
          <input id="avatar" type="file" class="d-none">
          <label id="avatar-btn" for="avatar" class="bg-body-secondary rounded-circle border border-white position-absolute text-center"><i class="bi bi-pencil"></i></label>
        </div>
      </div>

      <div id="user-info" class="col-12 col-sm-5 mb-2 px-2">
        <h6 class="fw-semibold">Thông tin</h6>
        <hr>
        <div class="user-information d-flex justify-content-between">
          <div class="text-secondary">
            <p>Họ tên:</p>
            <p>Gmail:</p>
            <p>Ngày sinh:</p>
            <p>Số điện thoại:</p>
          </div>

          <div>
            <p><strong>Đặng Nguyễn Tiền Hậu</strong></p>
            <p><strong>dnth@gmail.com</strong></p>
            <p><strong>01/01/2003</strong></p>
            <p><strong>0987654321</strong></p>
          </div>
        </div>
      </div>

      <div id="user-account" class="col-12 col-sm-5 mb-2 px-2">
        <h6 class="fw-semibold">Tài khoản</h6>
        <hr>
        <div class="user-information d-flex justify-content-between">
          <div class="text-secondary text-nowrap me-2 d-flex flex-column justify-content-between">
            <p>Tài khoản:</p>
            <p>Mật khẩu:</p>
          </div>

          <div class="text-break">
            <p><strong>haudn123</strong></p>
            <a id="change-password-btn" href="#">Đổi mật khẩu</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade show" id="change-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="change-password-modal__label" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="change-password-modal__label">Đổi mật khẩu</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="InputPasswordOld" class="mb-1">Mật khẩu cũ</label>
        <div class="input-group mb-3 w-100">
          <input type="password" class="form-control border-end-0" id="InputPasswordOld" placeholder="Nhập mật khẩu mới">
          <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
        </div>

        <label for="InputPassword1" class="mb-1">Nhập mật khẩu mới</label>
        <div class="input-group mb-3 w-100">
          <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu mới">
          <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
        </div>

        <label for="InputPassword2" class="mb-1">Xác nhận mật khẩu</label>
        <div class="input-group mb-3 w-100">
          <input type="password" class="form-control border-end-0" id="InputPassword2" placeholder="Xác nhận mật khẩu">
          <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="change-password-submit">Xác nhận</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>