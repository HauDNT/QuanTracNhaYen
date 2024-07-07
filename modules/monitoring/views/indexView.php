<!-- Header -->
<?php require "./layout/header.php" ?>
<?php require "./layout/sidebar.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0 bg-white shadow-sm flex-fill flex-column rounded-3 overflow-hidden position-relative">
    <button id="box-left-btn" class="btn bg-white border-0 w-auto position-absolute z-3 px-2 py-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#box-left-map" aria-controls="box-left-map"><i class="bi bi-list fs-4"></i></button>

    <button id="add-station-btn" class="btn bg-white border-0 position-absolute z-3 p-0"><i class="bi bi-geo-alt-fill"></i></button>

    <div class="offcanvas offcanvas-start position-absolute shadow border-0 rounded-3" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="box-left-map" aria-labelledby="boxLeftMapLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-semibold" id="boxLeftMapLabel">Danh sách trạm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="input-group mb-3">
          <label for="search" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search" class="px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>

        <ul id="stations-list" class="list-group">
          <?php if (count($list_station_info) > 0) : ?>
            <?php foreach ($list_station_info as $station) : ?>
              <li class="list-group-item list-group-item-action border-0 mb-2 rounded-3 shadow-sm" aria-current="true">
                <div class="d-flex align-items-center w-100">
                  <div data-value="<?= $station['longitude'] ?>-<?= $station['latitude'] ?>" class="station-content flex-fill me-4">
                    <p class="fw-semibold m-0"><?= $station['name'] ?></p>
                    <small class="text-secondary d-block mb-1">
                      <i class="bi bi-geo-alt text-primary"></i>
                      <?= $station['address'] ?>
                    </small>
                    <small class="d-flex justify-content-between flex-wrap">
                      <span class="text-secondary me-2">
                        <i class="bi bi-person text-primary"></i>
                        <?= $station['fullname'] ?>
                      </span>
                      <span class="text-secondary">
                        <i class="bi bi-telephone text-primary"></i>
                        <?= $station['phone_number'] ?>
                      </span>
                    </small>
                  </div>
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-station" class="dropdown-item rounded-3" href="?mod=monitoring&action=updateStation&id=<?= $station['id'] ?>">Chỉnh sửa</a></li>
                      <li><a id="station-setting" class="dropdown-item rounded-3" href="?mod=monitoring&action=settingStation&id=<?= $station['id'] ?>">Thiết lập</a></li>
                      <li class="mt-2 pt-2 border-2 border-top border-light-subtle"><a class="dropdown-item rounded-3 text-danger" href="?mod=monitoring&action=deleteStation&id=<?= $station['id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá trạm này?')">Xóa</a></li>
                    </ul>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else : ?>
            <h5 class="text-center text-secondary align-self-center">Không tìm thấy trạm</h5>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="offcanvas offcanvas-bottom position-absolute shadow border-0 rounded-3" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="box-chart-map" aria-labelledby="boxChartMapLabel">
    </div>
    <div id="map" view="map" class="h-100"></div>
  </div>
</div>

<!-- Modal add Station-->
<div class="modal fade" id="addStationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm trạm mới</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body overflow-y-scroll">
        <div class="mb-3">
          <label for="station-name" class="col-form-label">Tên trạm <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="station-name">
        </div>
        <div class="d-sm-flex">
          <div class="me-sm-2 flex-sm-fill mb-3">
            <label for="station-longitude" class="col-form-label">Kinh độ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="station-longitude">
          </div>
          <div class="flex-sm-fill mb-3">
            <label for="station-latitude" class="col-form-label">Vĩ độ <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="station-latitude">
          </div>
        </div>
        <div class="mb-3">
          <label for="station-address" class="col-form-label">Địa chỉ cụ thể <span class="text-danger">*</span></label>
          <input type="text" class="form-control" id="station-address">
        </div>
        <div class="mb-3">
          <label for="station_user" class="col-form-label">Người quản lý <span class="text-danger">*</span></label>
          <select class="form-select" aria-label="Default select example" id="station_user">
            <option selected hidden>-- Chọn người quản lý trạm --</option>
            <?php foreach ($list_user_info as $user) : ?>
              <option value="<?= $user['account_id'] ?>"><?= $user['fullname'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
        <button type="button" class="btn btn-primary" id="add_station">Thêm</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal update Station-->
<div class="modal fade" id="updateStationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>

<!-- Modal setting Station-->
<div class="modal fade" id="settingStationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
</div>

<!-- Footer -->
<?php require "./layout/footer.php" ?>