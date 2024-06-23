    <!-- Sidebar 0 -->
    <div class="sidebar offcanvas offcanvas-start p-2 border-0 shadow" tabindex="-1" id="sidebar-user" aria-labelledby="sidebar-userLabel">
       <div class="logo d-flex align-items-center">
          <button type="button" class="btn border-0 p-0 px-2" data-bs-dismiss="offcanvas" aria-label="Close">
             <i class="bi bi-list fs-3"></i>
          </button>
          <img src="public/img/logoKGU.png" alt="" height="32px">
          <div class="logo-name d-flex flex-column">
             <span class="ms-2 fw-semibold">Đại học kiên giang</span>
             <span class="ms-2 text-secondary">Hệ thống quản lý nhà yến</span>
          </div>
       </div>
       <div class="offcanvas-body px-0">
          <ul class="lists list-inline">
             <li class="list">
                <a href="?mod=monitoring" class="nav-link text-secondary <?= $active == "monitoring"  ? "active" : "" ?>">

                   <i class="bx bxs-home fs-5 me-2"></i>
                   <span class="link">Giám sát</span>
                </a>
             </li>
             <li class="list">
                <a href="?mod=report" class="nav-link text-secondary <?= $active == "report"  ? "active" : "" ?>">
                   <i class="bx bxs-bar-chart-alt-2 fs-5 me-2"></i>
                   <span class="link">Báo cáo</span>
                </a>
             </li>
             <li class="list">
                <a href="?mod=sensors" class="nav-link text-secondary <?= $active == "sensor"  ? "active" : "" ?>">
                   <i class="bx bxs-certification fs-5 me-2"></i>
                   <span class="link">Cảm biến</span>
                </a>
             </li>
             <li class="list">
                <a href="?mod=stations" class="nav-link text-secondary <?= $active == "stations"  ? "active" : "" ?>">
                   <i class='bx bx-broadcast fs-5 me-2'></i>
                   <span class="link">Trạm giám sát</span>
                </a>
             </li>
             <li class="list">
                <a href="?mod=units" class="nav-link text-secondary <?= $active == "unit"  ? "active" : "" ?>">
                   <i class='bx bxs-calculator fs-5 me-2'></i>
                   <span class="link">Đơn vị đo</span>
                </a>
             </li>
             <li class="list">
                <a href="?mod=users" class="nav-link text-secondary <?= $active == "user"  ? "active" : "" ?>">
                   <i class='bx bxs-user-circle fs-5 me-2'></i>
                   <span class="link">Tài khoản</span>
                </a>
             </li>
             <li class="list">
                <a href="#" class="nav-link text-secondary <?= $active == "setting"  ? "active" : "" ?>">
                   <i class="bx bxs-cog fs-5 me-2"></i>
                   <span class="link">Thiết lập</span>
                </a>
             </li>
          </ul>
       </div>
    </div>