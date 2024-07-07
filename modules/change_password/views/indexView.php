<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar-setting.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0">
    <ul id="tab-sensor" class="nav nav-tabs border-0">
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "personal"  ? "active" : "" ?>" href="?mod=personal">Cá nhân</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "change_password"  ? "active" : "" ?>" href="?mod=change_password">Đổi mật khẩu</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column <?= $active == "personal"  ? "rounded-end-3 rounded-bottom-3" : "rounded-3" ?>">
    <div class="row p-3 g-0 align-items-center h-100">
      <div class="change_password-form mx-auto p-2">
        <label for="InputPasswordOld" class="mb-1">Mật khẩu cũ</label>
        <div class="input-group mb-3 w-100">
          <input type="password" class="form-control border-end-0" id="InputPasswordOld" placeholder="Nhập mật khẩu cũ">
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

        <div id="notify-error" class="text-danger mb-3">
          <i class="bi bi-exclamation-circle-fill d-none"></i>
          <span></span>
        </div>

        <button type="button" class="btn btn-primary w-100" id="change-password-submit">Đổi mật khẩu</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>