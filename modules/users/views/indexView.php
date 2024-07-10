<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0 bg-white shadow-sm flex-fill flex-column rounded-3">
    <div class="row g-0 align-items-center p-3 pb-0 border-2 border-bottom border-light-subtle">
      <span class="fw-semibold w-auto mb-3 me-2">Người dùng</span>
      <div class="d-flex w-auto ms-auto mb-3">
        <div class="input-group w-auto me-2">
          <label for="search" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search" class="px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>
        <div class="filter dropdown me-2">
          <button class="btn btn-outline-secondary border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i>
          </button>
          <div class="dropdown-menu border border-light-subtle border-opacity-10 shadow-sm">
            <div class="dropdown-menu-header">
              <strong class="p-2">Bộ lọc</strong>
              <hr class="m-0 mt-2">
            </div>
            <div class="dropdown-menu-body p-2">
              <label for="user-role" class="text-secondary mb-1">Quyền hạn</label>
              <select id="user-role" class="form-select mb-2">
                <option value="-1" selected>Tất cả</option>
                <?php foreach ($list_roles as $role) : ?>
                  <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
                <?php endforeach; ?>
              </select>

              <label for="user-status" class="text-secondary mb-1">Trạng thái</label>
              <select id="user-status" class="form-select mb-2">
                <option value="-1" selected>Tất cả</option>
                <option value="0">Khóa</option>
                <option value="1">Hoạt động</option>
              </select>
              </select>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" data-bs-auto-close="false" data-bs-whatever="@mdo">
          <i class="bi bi-plus-lg"></i>
        </button>
      </div>
    </div>

    <div id="table" class="row g-0 mb-3 flex-fill">
      <?php if (count($list_users) > 0) : ?>
        <table class="table table-hover table-borderless align-self-start">
          <thead>
            <tr>
              <th class="text-center" width="80px">STT</th>
              <th class="text-start">Họ tên</th>
              <th class="text-start">Quyền hạn</th>
              <th class="text-start">Ngày tạo</th>
              <th class="text-start">Trạng thái</th>
              <th class="text-center" width="80px"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_users as $user) : ?>
              <tr>
                <th data-title="STT" class="text-center"><?= $user['no'] ?></th>
                <td data-title="Họ tên" class="text-start d-flex align-items-center flex-wrap">
                  <div class="d-flex align-items-center ms-2 ms-sm-0">
                    <img class="rounded-circle me-2" src="<?= $user['avatar'] ?>" alt="" width="36px" height="36px">
                    <div>
                      <span class="d-block"><?= $user['fullname'] ?></span>
                      <span class="d-block text-line-secondary"><?= $user['email'] ?></span>
                    </div>
                  </div>
                </td>
                <td data-title="Quyền hạn" class="text-start"><?= $user['role'] ?></td>
                <td data-title="Ngày tạo" class="text-start"><?= $user['date_created'] ?></td>
                <td data-title="Trạng thái" class="text-start">
                  <span class="badge <?= $user['status'] == 0 ? 'bg-danger text-danger' : 'bg-success text-success' ?> bg-opacity-25">
                    <?= $user['status'] == 0 ? "Khóa" : "Hoạt động" ?>
                  </span>
                </td>
                <td data-title="Chức năng" class="text-center">
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-user" class="dropdown-item rounded-3" href="?mod=users&action=updateUser&views=update&id=<?= $user['id'] ?>">Chỉnh sửa</a></li>
                      <li><a class="dropdown-item rounded-3 text-danger" href="?mod=users&action=deleteUser&id=<?= $user['id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá người dùng này?')">Xóa</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else : ?>
        <h4 class="text-center text-secondary align-self-center">Không có dữ liệu</h4>
      <?php endif; ?>
    </div>

    <div class="row g-0 p-3 border-2 border-top border-light-subtle mt-auto">
      <ul class="pagination justify-content-center m-0">
        <li class="page-item me-auto <?= $current_page <= 1 ? "disabled" : "" ?>">
          <a class="page-link border-0 rounded-2" href="<?= $current_page > 1 ? $current_page - 1 : $current_page ?>"><i class="bi bi-arrow-left"></i> Trước</a>
        </li>
        <?php for ($i = 1; $i <= $total_page; $i++) : ?>
          <?php if ($i > $current_page - 2 &&  $i < $current_page + 2) : ?>
            <li class="page-item me-2">
              <a class="page-link border-0 rounded-2 <?= $current_page == $i ? "active" : "" ?>" href="<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endif; ?>
        <?php endfor; ?>
        <li class="page-item ms-auto <?= $current_page >= $total_page ? "disabled" : "" ?>">
          <a class="page-link border-0 rounded-2" href="<?= $current_page < $total_page ? $current_page + 1 : $current_page ?>">Sau <i class="bi bi-arrow-right"></i></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm người dùng</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body overflow-y-scroll pe-2">
        <div class="mb-3">
          <label for="full_name" class="col-form-label">Họ tên <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="full_name">
        </div>
        <div class="mb-3">
          <label for="username" class="col-form-label">Tài khoản <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="username">
        </div>
        <div class="d-sm-flex">
          <div class="me-sm-2 flex-sm-fill mb-3">
            <label for="password" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control border-end-0" id="password">
              <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
            </div>
          </div>
          <div class="flex-sm-fill mb-3">
            <label for="repeat_password" class="col-form-label">Xác nhận mật khẩu</label>
            <div class="input-group">
              <input type="password" class="form-control border-end-0" id="repeat_password">
              <button class="eye-btn input-group-text bg-transparent"><i class="bi bi-eye-slash"></i></button>
            </div>
          </div>
        </div>
        <div class="d-sm-flex">
          <div class="me-sm-2 flex-sm-fill mb-3">
            <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="flex-sm-fill mb-3">
            <label for="phone_number" class="col-form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone_number">
          </div>
        </div>
        <div class="d-sm-flex">
          <div class="me-sm-2 flex-sm-fill mb-3">
            <label for="birthday" class="col-form-label">Ngày sinh</label>
            <div class="input-group">
              <input type="text" class="form-control border-end-0" id="birthday" placeholder="dd-mm-yyyy">
              <label for="birthday" class="input-group-text bg-transparent text-primary"><i class="bi bi-calendar3"></i></label>
            </div>
          </div>
          <div class="flex-sm-fill mb-3">
            <label for="gender" class="col-form-label">Giới tính</label>
            <select class="form-select" id="gender" aria-label="Default select example">
              <option value="1" selected>Nam</option>
              <option value="0">Nữ</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="role" class="col-form-label">Quyền <span class="text-danger">*</span></label>
          <select class="form-select" id="role" aria-label="Default select example">
            <option selected hidden disabled>-- Chọn quyền --</option>
            <?php foreach ($list_roles as $item) : ?>
              <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
        <button type="button" class="btn btn-primary" id="add_user">Thêm</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="updateUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>