<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0">
    <ul id="tab-sensor" class="nav nav-tabs border-0">
      <li class="nav-item">
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "report"  ? "active" : "" ?>" href="?mod=sensors">Báo cáo</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column <?= $active == "report"  ? "rounded-end-3 rounded-bottom-3" : "rounded-3" ?>">
    <div class="row g-0 align-items-center p-3 border-2 border-bottom border-light-subtle">
      <div class="d-flex w-auto ms-auto">
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
              <label for="station" class="text-secondary mb-1">Trạm</label>
              <select id="station" class="form-select mb-2">
                <option value="-1" selected>Tất cả</option>
                <?php foreach ($station as $item) : ?>
                  <option value="<?= $item["id"] ?>"><?= $item["name"] ?></option>
                <?php endforeach; ?>
              </select>

              <label for="indicator" class="text-secondary mb-1">Chỉ số</label>
              <select id="indicator" class="form-select mb-2">
                <option value="-1" selected>Tất cả</option>
                <?php foreach ($indicator as $item) : ?>
                  <option value="<?= $item["id"] ?>"><?= $item["name"] ?></option>
                <?php endforeach; ?>
              </select>

              <label for="date" class="text-secondary mb-1">Thời gian</label>
              <select id="date" class="form-select">
                <option value="-1" selected>Tháng</option>
                <option value="this_week">Tuần này</option>
                <option value="last_week">Tuần trước</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-0 row-cols-1 row-cols-sm-2 p-3 ">
      <div class="col">
        <canvas id="report-barChart" class="chart rounded-3 overflow-hidden shadow-sm py-2 px-3 border border-light-subtle border-opacity-10 me-0 me-sm-3 mb-3 mb-sm-0"></canvas>
      </div>
      <div class="col">
        <canvas id="report-lineChart" class="chart rounded-3 overflow-hidden shadow-sm py-2 px-3 border border-light-subtle border-opacity-10"></canvas>
      </div>
    </div>

    <div id="table" class="row g-0 mb-3 flex-fill">
      <table class="table table-hover table-borderless align-self-start w-100 nowrap">
        <thead>
          <tr>
            <th class="text-center">Chỉ số</th>
            <th class="text-center">Giá trị</th>
            <th class="text-center">Trạm</th>
            <th class="text-center">Tầng</th>
            <th class="text-center">Thời gian</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
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
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>