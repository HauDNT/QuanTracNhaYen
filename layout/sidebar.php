    <!-- Sidebar 0 -->
    <div class="sidebar offcanvas offcanvas-start border-0 me-2 p-2 shadow-sm" tabindex="-1" id="sidebar-user" aria-labelledby="sidebar-userLabel">
      <div class="offcanvas-header px-3">
        <h5 class="m-0 p-0 text-primary d-flex align-items-center">
          <i class="bi bi-grid-fill fs-3 me-2"></i>
          Quản lý hệ thống
        </h5>
      </div>

      <div class="offcanvas-body px-2">
        <ul class="lists list-inline">
          <li class="list">
            <a href="?mod=monitoring" class="nav-link text-secondary py-2 <?= $active == "monitoring"  ? "active" : "" ?>">
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
            <a href="?mod=stations" class="nav-link text-secondary py-2 <?= $active == "stations"  ? "active" : "" ?>">
              <i class='bi bi-broadcast-pin me-2'></i>
              <span class="link">Trạm giám sát</span>
            </a>
          </li>
          <li class="list">
            <a href="?mod=users" class="nav-link text-secondary py-2 <?= $active == "user"  ? "active" : "" ?>">
              <i class='bi bi-people me-2'></i>
              <span class="link">Tài khoản</span>
            </a>
          </li>
          <li class="list">
            <a href="#" class="nav-link text-secondary py-2 <?= $active == "setting"  ? "active" : "" ?>">
              <i class="bi bi-gear me-2"></i>
              <span class="link">Thiết lập</span>
            </a>
          </li>
        </ul>
      </div>
    </div>