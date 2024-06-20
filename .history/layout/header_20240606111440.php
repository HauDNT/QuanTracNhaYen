<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhà yến</title>

    <!-- Link CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css?v=<?= time() ?>" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Link Icon -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css?v=<?= time() ?>" rel="stylesheet" />

    <!-- Link CSS -->
    <link rel="stylesheet" href="public/css/styles.css?v=<?= time() ?>">

    <!-- Link Mapbox -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">
</head>

<body>
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
    <nav class="d-flex align-items-center bg-white shadow-sm justify-content-between px-2 z-3">
        <div class="container-xxl p-0">
            <div class="logo d-flex align-items-center">
                <button class="menu-button btn border-0 p-0 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar-user" aria-controls="sidebar-user">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <img src="public/img/logoKGU.png" alt="" height="32px">
                <div class="logo-name d-flex flex-column">
                    <span class="ms-2 fw-semibold">Đại học kiên giang</span>
                    <span class="ms-2 text-secondary">Hệ thống quản lý nhà yến</span>
                </div>
            </div>

            <div class=""></div>
        </div>
    </nav>