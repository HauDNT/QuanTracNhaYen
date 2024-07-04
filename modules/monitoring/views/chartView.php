<div class="offcanvas-header">
  <h5 class="offcanvas-title fw-semibold" id="boxChartMapLabel"><?= $station["name"] ?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
  <?php if (count($position_list) > 0) : ?>
    <select class="form-select w-auto mb-3" id="position" aria-label="Default select example">
      <?php foreach ($position_list as $position) : ?>
        <option value="<?= $position["position"] ?>">Tầng <?= $position["position"] ?></option>
      <?php endforeach; ?>
    </select>

    <div class="row row-cols-1 row-cols-sm-2 gx-3 gy-3 gy-sm-0">
      <div class="col">
        <canvas id="lineChart" class="chart rounded-3 overflow-hidden shadow-sm py-2 px-3 border border-light-subtle border-opacity-10"></canvas>
      </div>
      <div class="col">
        <canvas id="barChart" class="chart rounded-3 overflow-hidden shadow-sm py-2 px-3 border border-light-subtle border-opacity-10"></canvas>
      </div>
    </div>
  <?php else: ?>
    <h4 class="text-center text-secondary align-self-center">Không có dữ liệu</h4>
  <?php endif; ?>

</div>