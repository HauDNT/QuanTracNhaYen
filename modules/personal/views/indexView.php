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
    <div class="row p-3 g-0">
      <div class="info-form mx-auto p-2">
        <div id="user-avatar" class="d-flex align-item-center justify-content-center">
          <div class="position-relative d-inline-block rounded-circle overflow-hidden mb-2">
            <img src="<?= $user_info["avatar"] ?>" alt="" width="100px" height="100px">
            <input id="avatar" type="file" class="d-none">
            <label id="avatar-btn" for="avatar" class="position-absolute bg-secondary bg-opacity-50 text-center text-white text-opacity-75">
              <i class="bi bi-camera-fill fs-5"></i>
            </label>
          </div>
        </div>

        <p class="text-center"><?= $user_info["name"] ?></p>

        <div id="user-info" class="mb-3">
          <div class="mb-2">
            <label for="full_name" class="mb-1">Họ và tên</label>
            <input type="text" class="form-control" id="full_name" value="<?= $user_info["fullname"] ?>">
          </div>

          <div class="mb-2">
            <label for="email" class="mb-1">Email</label>
            <input type="email" class="form-control" id="email" value="<?= $user_info["email"] ?>" disabled>
          </div>

          <div class="mb-2">
            <label for="gender" class="col-form-label">Giới tính</label>
            <select class="form-select" id="gender" aria-label="Default select example">
              <option value="1" <?= $user_info["gender"] == 1 ? "selected" : "" ?>>Nam</option>
              <option value="0" <?= $user_info["gender"] == 0 ? "selected" : "" ?>>Nữ</option>
            </select>
          </div>

          <div class="mb-2">
            <label for="phone_number" class="col-form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone_number" value="<?= $user_info["phone_number"] ?>" disabled>
          </div>

          <div class="mb-2">
            <label for="birthday" class="col-form-label">Ngày sinh</label>
            <div class="input-group">
              <input type="text" class="form-control border-end-0" id="birthday" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime($user_info["birthday"])) ?>">
              <label for="birthday" class="input-group-text bg-transparent text-primary"><i class="bi bi-calendar3"></i></label>
            </div>
          </div>

          <div class="mb-2">
            <label for="date_created" class="col-form-label">Ngày tạo</label>
            <input type="text" class="form-control border-end-0" id="date_created" placeholder="dd-mm-yyyy" value="<?= date('d-m-Y', strtotime($user_info["date_created"])) ?>" disabled>
          </div>
        </div>

        <button id="update-info-submit" class="btn btn-primary w-100">Cập nhật thông tin</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>