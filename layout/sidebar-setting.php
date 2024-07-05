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

      <div class="offcanvas-header ps-2">
        <a href="?mod=monitoring" class="text-decoration-none fs-5 text-primary d-flex align-items-center m-0 p-0 lh-1">
          <i class="bi bi-chevron-left me-2"></i>
          <i class="bi bi-gear-fill fs-3 me-2"></i>
          Thiết lập
        </a>
      </div>

      <div class="offcanvas-body px-2">
        <ul class="lists list-inline">
          <li class="list">
            <a href="?mod=information" class="nav-link text-secondary py-2 <?= $active == "information" ? "active" : "" ?>">
              <i class="bi bi-person me-2"></i>
              <span class="link">Thông tin cá nhân</span>
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