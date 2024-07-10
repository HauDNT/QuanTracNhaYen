<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0 bg-white shadow-sm mb-2 rounded-3">
    <div class="row g-0 align-items-center p-3">
      <span class="fw-semibold w-auto">Biểu đồ</span>
      <div class="d-flex w-auto ms-auto">
        <div class="filter dropdown">
          <button class="btn btn-outline-secondary border dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
            <i class="bi bi-funnel"></i>
          </button>
          <div class="dropdown-menu border border-light-subtle border-opacity-10 shadow-sm">
            <div class="dropdown-menu-header">
              <strong class="p-2">Bộ lọc</strong>
              <hr class="m-0 mt-2">
            </div>
            <div class="dropdown-menu-body p-2">
              <label for="chart-date" class="text-secondary mb-1">Thời gian</label>
              <select id="chart-date" class="form-select">
                <option value="month" selected>Tháng</option>
                <option value="this_week">Tuần này</option>
                <option value="last_week">Tuần trước</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-0 p-3">
      <canvas id="report-lineChart" class="chart bg-white"></canvas>
    </div>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column rounded-3">
    <div class="row g-0 align-items-center p-3 pb-0 border-2 border-bottom border-light-subtle">
      <span class="fw-semibold w-auto mb-3">Bảng số liệu</span>
      <div class="d-flex w-auto ms-auto mb-3">
        <div class="input-group w-auto me-2">
          <label for="search" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search" class="px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>
        <div class="d-flex w-auto">
          <div class="filter-report dropdown">
            <button class="btn btn-outline-secondary border dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
              <i class="bi bi-funnel"></i>
            </button>
            <div class="dropdown-menu border border-light-subtle border-opacity-10 shadow-sm">
              <div class="dropdown-menu-header">
                <strong class="p-2">Bộ lọc</strong>
                <hr class="m-0 mt-2">
              </div>
              <div class="dropdown-menu-body p-2">
                <label for="report-position" class="text-secondary mb-1">Tầng</label>
                <select id="report-position" class="form-select mb-2">
                  <option value="-1" selected>Tất cả</option>
                  <?php foreach ($position as $item) : ?>
                    <option value="<?= $item["position"] ?>">Tầng <?= $item["position"] ?></option>
                  <?php endforeach; ?>
                </select>

                <label for="report-indicator" class="text-secondary mb-1">Chỉ số</label>
                <select id="report-indicator" class="form-select mb-2">
                  <option value="-1" selected>Tất cả</option>
                  <?php foreach ($indicator as $item) : ?>
                    <option value="<?= $item["id"] ?>"><?= $item["name"] ?></option>
                  <?php endforeach; ?>
                </select>

                <div class="d-flex">
                  <div class="me-2">
                    <label for="date-start" class="col-form-label">Từ ngày</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-end-0" id="date-start" placeholder="dd-mm-yyyy">
                      <i class="bi bi-calendar3 input-group-text bg-transparent text-primary"></i>
                    </div>
                  </div>

                  <div>
                    <label for="date-end" class="col-form-label">Đến ngày</label>
                    <div class="input-group">
                      <input type="text" class="form-control border-end-0" id="date-end" placeholder="dd-mm-yyyy">
                      <i class="bi bi-calendar3 input-group-text bg-transparent text-primary"></i>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="table" class="row g-0 mb-3 flex-fill">
      <?php if (count($data_table) > 0) : ?>
        <div id="table" class="row g-0 mb-3 flex-fill">
          <table class="table table-borderless align-self-start w-100 nowrap">
            <thead>
              <tr>
                <th class="text-center" width="80px">STT</th>
                <th class="text-center">Trạm</th>
                <th class="text-center">Tầng</th>
                <th class="text-center">Chỉ số</th>
                <th class="text-center">Giá trị</th>
                <th class="text-center">Thời gian</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data_table as $item) : ?>
                <tr>
                  <th data-title="STT" class="text-center"><?= $item['no'] ?></th>
                  <td data-title="Trạm" class="text-center"><?= $item['station'] ?></td>
                  <td data-title="Tầng" class="text-center"><?= $item['position'] ?></td>
                  <td data-title="Chỉ số" class="text-center"><?= $item['indicator'] ?></td>
                  <td data-title="Giá trị" class="text-center">
                    <?= $item["unit"] == "safety" ? ($item["value"] == 1 ? "An toàn" : "Báo động") : ($item['value'] . $item["unit"]) ?>
                  </td>
                  <td data-title="Thời gian" class="text-center"><?= $item['createdAt'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </table>
        </div>
      <?php else : ?>
        <h4 class="text-center text-secondary align-self-center mt-3">Không có dữ liệu</h4>
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