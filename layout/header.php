<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/img/logoKGU.png" />
  <title>Quản lý nhà yến</title>

  <!-- Link CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?= time() ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Link Icon -->
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css?v=<?= time() ?>" rel="stylesheet" />

  <!-- Link Mapbox -->
  <script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">


  <!-- Link Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

  <!-- Link CSS -->
  <link rel="stylesheet" href="public/css/styles.css?v=<?= time() ?>">
</head>

<body class="bg-body-secondary">
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="notify" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">

        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="d-flex align-items-center bg-white justify-content-between px-2 z-3 shadow-sm">
    <div class="container-fluid p-0 d-flex align-items-center flex-wrap">
      <button class="menu-button btn border-0 p-0 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-user" aria-controls="sidebar-user">
        <i class="bi bi-list fs-3"></i>
      </button>
      <div class="logo d-flex align-items-center">
        <a class="nav-link d-flex align-items-center" href="?mod=monitoring">
          <img src="public/img/logoKGU.png" alt="" height="36px">
          <div class="logo-name d-flex flex-column">
            <span class="ms-2 text-dark-emphasis fw-semibold">Đại học kiên giang</span>
            <span class="ms-2 text-secondary">Hệ thống quản lý nhà yến</span>
          </div>
        </a>
      </div>
      <ul class="action-list list-inline ms-auto m-0 p-0 d-flex align-items-center">
        <li class="action-item me-2">
          <a href="?mod=personal" class="nav-link btn bg-transparent border-0 rounded-circle dropdown-toggle p-0 d-flex align-items-center" role="button">
            <i class="bx bx-cog fs-4 text-secondary mx-auto"></i>
          </a>
        </li>
        <li class="action-item ms-2">
          <img src="<?= $_SESSION["user_info"]["avatar"] ?>" class="rounded-circle" alt="" width="36px" height="36px">
        </li>
      </ul>
    </div>
  </nav>

  <div class="main-page container-fluid d-flex p-2 pe-0">