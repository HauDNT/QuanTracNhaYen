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
        <a class="nav-link text-secondary fw-semibold border-0 <?= $active == "unit"  ? "active" : "" ?>" href="?mod=units">Đơn vị</a>
      </li>
    </ul>
  </div>

  <div class="row g-0 bg-white shadow-sm flex-fill flex-column <?= $active == "sensor"  ? "rounded-end-3 rounded-bottom-3" : "rounded-3" ?>">
    <div class="row g-0 align-items-center p-3 border-2 border-bottom border-light-subtle">
      <div class="d-flex w-auto ms-auto">
        <div class="input-group w-auto me-2">
          <label for="" class="d-flex align-items-center text-secondary text-center bg-white border border-end-0 rounded-start-3 ps-2 pe-1"><i class="bi bi-search"></i></label>
          <input id="search-unit" class="search px-1 form-control border-start-0 rounded-end-3 text-secondary" type="search" placeholder="Tìm kiếm..." aria-label="Search">
        </div>
        <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addUnitModal" data-bs-whatever="@mdo">
          <i class="bi bi-plus-lg"></i>
        </button>
      </div>
    </div>

    <div id="table" class="row g-0 mb-3 flex-fill">
      <?php if (count($list_units) > 0) : ?>
        <table class="table table-hover table-borderless align-self-start">
          <thead>
            <tr>
              <th class="text-center" width="80px">STT</th>
              <th class="text-center">Đơn vị</th>
              <th class="text-center">Ký hiệu</th>
              <th class="text-center" width="80px"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_units as $unit) : ?>
              <tr>
                <th data-title="STT" class="text-center"><?= $unit['no'] ?></th>
                <td data-title="Đơn vị" class="text-center"><?= $unit['name'] ?></td>
                <td data-title="Ký hiệu" class="text-center"><?= $unit['symbol'] ?></td>
                <td data-title="Chức năng" class="text-center">
                  <div class="dropdown">
                    <button class="btn bg-transparent border-0 p-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu px-2">
                      <li><a id="view-unit" class="dropdown-item rounded-3" href="?mod=units&action=updateUnit&views=update&id=<?= $unit['id'] ?>">Chỉnh sửa</a></li>
                      <li><a class="dropdown-item rounded-3 text-danger" href="?mod=units&action=deleteUnit&id=<?= $unit['id'] ?>" onclick="return confirm('Bạn có chắc muốn xoá đơn vị này?')">Xóa</a></li>
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

<!-- Modal add Unit-->
<div class="modal fade" id="addUnitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm đơn vị</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body overflow-y-scroll pe-2">
        <div class="mb-3">
          <label for="unit-name" class="col-form-label">Tên đơn vị</label>
          <input type="text" class="form-control" id="unit_name">
        </div>
        <div class="mb-3">
          <label for="unit_symbol" class="col-form-label">Ký hiệu</label>
          <input type="text" class="form-control" id="unit_symbol">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary ms-auto mr-4" data-bs-dismiss="modal">Trở lại</button>
        <button type="button" class="btn btn-primary ms-2" id="add_unit">Thêm</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal update Unit-->
<div class="modal fade" id="updateUnitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

</div>
<!-- Footer -->
<?php require "./layout/footer.php" ?>