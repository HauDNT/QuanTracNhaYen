<!-- Header -->
<?php require "./layout/header.php" ?>

<div class="content w-100 p-0 d-flex flex-column">
  <div class="row g-0 bg-white shadow-sm flex-fill flex-column rounded-3">
    <div class="row g-0 align-items-center p-3 border-2 border-bottom border-light-subtle">
      <strong class="w-auto">Danh sách trạm</strong>
      <div class="d-flex w-auto ms-auto">
        <div class="input-group w-auto">
          <label for="" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search-station" class="search px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>
        <div class="filter dropdown me-2">
          <button class="btn btn-outline-secondary border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-funnel"></i>
          </button>
          <!-- <div class="dropdown-menu border border-light-subtle border-opacity-10 shadow-sm">
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
          </div> -->
        </div>
        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addStationModal" data-bs-whatever="@mdo">
          <i class="bi bi-plus-lg"></i>
        </button>
      </div>
    </div>

    <div id="table" class="row g-0 mb-3 flex-fill">
      <?php if (count($list_station_info) > 0) : ?>
        <table class="table table-hover table-borderless align-self-start">
          <thead>
            <tr>
              <th class="text-center" width="80px">STT</th>
              <th class="text-start">Tên trạm</th>
              <th class="text-start">Tung độ</th>
              <th class="text-start">Hoành độ</th>
              <th class="text-start">Địa chỉ Web Server</th>
              <th class="text-start">Người quản lý</th>
              <th class="text-center" width="80px"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_station_info as $index => $station) : ?>
              <tr>
                <th class="text-center"><?= $index + 1 ?></th>
                <td class="text-start">
                  <i class='bi bi-broadcast-pin'></i>
                  <?= $station['name'] ?>
                </td>
                <td class="text-start"><?= $station['longtitude'] ?></td>
                <td class="text-start"><?= $station['langtitude'] ?></td>
                <td class="text-start">
                  <a href="http://<?= $station['urlServer'] ?>" target="_blank" rel="noopener noreferrer">
                    <?= $station['urlServer'] ?>
                  </a>
                </td>
                <td class="text-start">
                  <i class="bi bi-person"></i>
                  <?= $station['fullname'] ?>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-sensor" class="dropdown-item rounded-3" href="?mod=stations&action=updateStation&views=update&id=<?= $station['id'] ?>">Chỉnh sửa</a></li>
                      <li><a class="dropdown-item rounded-3 text-danger" href="?mod=stations&action=deleteStation&id=<?= $station['id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá trạm này?')">Xóa</a></li>
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
        <li class="page-item me-auto disabled">
          <a class="page-link border-0 rounded-2"><i class="bi bi-arrow-left"></i> Trước</a>
        </li>
        <li class="page-item me-2">
          <a class="page-link border-0 rounded-2 active" href="#">1</a>
        </li>
        <li class="page-item me-2">
          <a class="page-link border-0 rounded-2" href="#">2</a>
        </li>
        <li class="page-item me-2">
          <a class="page-link border-0 rounded-2" href="#">3</a>
        </li>
        <li class="page-item ms-auto">
          <a class="page-link border-0 rounded-2" href="#">Sau <i class="bi bi-arrow-right"></i></a>
        </li>
      </ul>

    </div>
  </div>
</div>

<!-- Modal add Station-->
<div class="modal fade" id="addStationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm trạm mới</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="station-name" class="col-form-label">Tên trạm</label>
          <input type="text" class="form-control" id="station-name">
        </div>
        <div id="map" class="mb-3"></div>
        <div class="mb-3">
          <label for="station-longtitude" class="col-form-label">Kinh độ</label>
          <input type="text" class="form-control" id="station-longtitude">
        </div>
        <div class="mb-3">
          <label for="station-langtitude" class="col-form-label">Vĩ độ</label>
          <input type="text" class="form-control" id="station-langtitude">
        </div>
        <div class="mb-3">
          <label for="station-langtitude" class="col-form-label">Địa chỉ DDNS URL</label>
          <input type="text" class="form-control" id="station-langtitude">
        </div>
        <div class="mb-3">
          <label for="station-langtitude" class="col-form-label">Chi tiết</label>
          <input type="text" class="form-control" id="station-langtitude">
        </div>
        <div class="mb-3">
          <label for="station_user" class="col-form-label">Người quản lý</label>
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

<!-- Footer -->
<?php require "./layout/footer.php" ?>