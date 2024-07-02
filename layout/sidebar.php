    <!-- Sidebar 0 -->
    <div class="sidebar offcanvas offcanvas-start border-0 me-2 p-2 shadow-sm" tabindex="-1" id="sidebar-user" aria-labelledby="sidebar-userLabel">
      <div class="logo d-flex align-items-center border-2 border-bottom mb-2">
        <a class="nav-link d-flex align-items-center" href="?mod=monitoring">
          <img src="public/img/logoKGU.png" alt="" height="36px">
          <div class="logo-name d-flex flex-column">
            <span class="ms-2 text-dark-emphasis fw-semibold">Đại học kiên giang</span>
            <span class="ms-2 text-secondary">Hệ thống quản lý nhà yến</span>
          </div>
        </a>
      </div>

      <div class="offcanvas-header px-3">
        <h5 class="m-0 p-0 text-primary d-flex align-items-center">
          <i class="bi bi-grid-fill fs-3 me-2"></i>
          Quản lý hệ thống
        </h5>
      </div>

      <div class="offcanvas-body px-2">
        <ul class="lists list-inline">
          <li class="list">
            <a href="?mod=monitoring" class="nav-link text-secondary py-2 <?= $active == "monitoring" || $active == "station" ? "active" : "" ?>">
              <i class="bi bi-display me-2"></i>
              <span class="link">Giám sát</span>
            </a>
          </li>
          <li class="list">
            <a href="?mod=report" class="nav-link text-secondary py-2 <?= $active == "report"  ? "active" : "" ?>">
              <i class="bi bi-clipboard2-data me-2"></i>
              <span class="link">Thống kê</span>
            </a>
          </li>
          <li class="list">
            <a href="?mod=sensors" class="nav-link text-secondary py-2 <?= $active == "sensor" || $active == "unit"  ? "active" : "" ?>">
              <i class="bi bi-cpu me-2"></i>
              <span class="link">Cảm biến</span>
            </a>
          </li>
          <li class="list">
            <a href="?mod=users" class="nav-link text-secondary py-2 <?= $active == "user"  ? "active" : "" ?>">
              <i class='bi bi-people me-2'></i>
              <span class="link">Người dùng</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="offcanvas-footer mt-auto px-2">
        <ul class="lists list-inline">
          <li class="list">
            <a href="#" class="nav-link text-secondary py-2">
              <i class="bi bi-box-arrow-right me-2"></i>
              <span class="link">Đăng xuất</span>
            </a>
          </li>
        </ul>
      </div>
    </div>