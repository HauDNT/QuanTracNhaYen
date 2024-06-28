<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0">
    <ul id="tab-sensor" class="nav nav-tabs border-0">
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "user"  ? "active" : "" ?>" href="?mod=users">Người dùng</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column <?= $active == "user"  ? "rounded-end-3 rounded-bottom-3" : "rounded-3" ?>">
    <div class="row g-0 align-items-center p-3 border-2 border-bottom border-light-subtle">
      <div class="d-flex w-auto ms-auto">
        <div class="input-group w-auto me-2">
          <label for="" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search-sensor" class="search px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
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
              <label for="sensor-status" class="text-secondary mb-1">Trang thái</label>
              <select id="sensor-status" class="form-select">
                <option value="-1" selected>Tất cả</option>
                <option value="0">Ngừng hoạt động</option>
                <option value="1">Hoạt động</option>
              </select>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSensorModal" data-bs-whatever="@mdo">
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
              <th class="text-start">Email</th>
              <th class="text-start">Số điện thoại</th>
              <th class="text-start">Vai trò</th>
              <th class="text-center" width="80px"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_users as $user) : ?>
              <tr>
                <th data-title="STT" class="text-center"><?= $user['no'] ?></th>
                <td data-title="Họ tên" class="text-start"><?= $user['fullname'] ?></td>
                <td data-title="Email" class="text-start text-break"><?= $user['email'] ?></td>
                <td data-title="Số điện thoại" class="text-start text-break"><?= $user['phone_number'] ?></td>
                <td data-title="Vai trò" class="text-start"><?= $user['role'] ?></td>
                <td data-title="Chức năng" class="text-center">
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-sensor" class="dropdown-item rounded-3" href="?mod=users&action=updateUser&views=update&id=<?= $user['account_id'] ?>">Chỉnh sửa</a></li>
                      <li><a class="dropdown-item rounded-3 text-danger" href="?mod=users&action=deleteUser&id=<?= $user['account_id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá người dùng này?')">Xóa</a></li>
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

<!-- Footer -->
<?php require "./layout/footer.php" ?>