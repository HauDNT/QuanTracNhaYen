<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0">
    <ul id="tab-sensor" class="nav nav-tabs border-0">
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "sensor"  ? "active" : "" ?>" href="?mod=sensors">Cảm biến</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "indicators"  ? "active" : "" ?>" href="?mod=indicators">Chỉ số</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column <?= $active == "sensor"  ? "rounded-end-3 rounded-bottom-3" : "rounded-3" ?>">
    <div class="row g-0 align-items-center p-3 border-2 border-bottom border-light-subtle">
      <div class="d-flex w-auto ms-auto">
        <div class="input-group w-auto me-2">
          <label for="search" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search" class="px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>
        <div class="filter dropdown me-2">
          <button class="btn btn-outline-secondary border dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
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
                <option value="0">Ngắt kết nối</option>
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
      <?php if (count($list_sensor) > 0) : ?>
        <table class="table table-hover table-borderless align-self-start w-100 nowrap">
          <thead>
            <tr>
              <th class="text-center" width="80px">STT</th>
              <th class="text-start">Tên cảm biến</th>
              <th class="text-start">Tên trạm</th>
              <th class="text-center">Tầng</th>
              <th class="text-center">Trạng thái</th>
              <th class="text-center" width="80px"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_sensor as $sensor) : ?>
              <tr>
                <th data-title="STT" class="text-center"><?= $sensor["no"] ?></th>
                <td data-title="Tên cảm biến" class="text-start d-flex align-items-center">
                  <div class="d-flex align-items-center w-auto ms-2">
                    <i class="bi bi-cpu me-2 fs-4"></i>
                    <div>
                      <span class="d-block"><?= $sensor['sensor_name'] ?></span>
                      <span class="d-block text-line-secondary text-secondary"><?= $sensor['sensor_id'] ?></span>
                    </div>
                  </div>
                </td>
                <td data-title="Tên trạm" class="text-start">
                  <?= !empty($sensor['station_name']) ? $sensor['station_name'] : "-" ?>
                </td>
                <td data-title="Tầng" class="text-center"><?= $sensor['position'] ?></td>
                <td data-title="Trạng thái" class="text-center">
                  <span class="badge <?= $sensor['connect_status'] == 0 ? 'bg-secondary text-secondary' : 'bg-success text-success' ?> bg-opacity-25">
                    <?= $sensor['connect_status'] == 0 ? "Ngắt kết nối" : "Hoạt động" ?>
                  </span>
                </td>
                <td data-title="Chức năng" class="text-center">
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-sensor" class="dropdown-item rounded-3" href="?mod=sensors&action=updateSensor&views=update&id=<?= $sensor['id'] ?>">Chỉnh sửa</a></li>
                      <?php if ($_SESSION['user_info']['role_id'] == 5) : ?>
                        <li><a class="dropdown-item rounded-3 text-danger" href="?mod=sensors&action=deleteSensor&id=<?= $sensor['id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá cảm biến này?')">Xóa</a></li>
                      <?php endif; ?>
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

<!-- Modal add Sensor-->
<div class="modal fade" id="addSensorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm cảm biến</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body overflow-y-scroll">
        <div class="mb-3">
          <label for="id_sensor" class="col-form-label">Mã cảm biến <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="id_sensor" placeholder="SS<?= date("Y") ?>00000">
        </div>
        <div class="mb-3">
          <label for="name_sensor" class="col-form-label">Tên cảm biến <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="name_sensor">
        </div>
        <div class="mb-3">
          <label for="station_sensor" class="col-form-label">Trạm</label>
          <select class="form-select" id="station_sensor">
            <option selected hidden disabled>-- Chọn trạm --</option>
            <?php foreach ($list_station as $value) { ?>
              <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="position_sensor" class="col-form-label">Tầng <span class="text-danger">*</span></label>
          <input type="number" class="form-control" id="position_sensor" value="1" min="1">
        </div>

        <div class="mb-3">
          <label for="threshold_setting" class="col-form-label">Thiết lập cảm biến</label>
          <select class="form-select" id="threshold_setting">
            <option value="0">Từ chối</option>
            <option value="1">Cho phép</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
        <button type="button" class="btn btn-primary" id="add_sensor">Thêm</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal update Sensor-->
<div class="modal fade" id="updateSensorModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>