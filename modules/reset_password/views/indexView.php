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

  <!-- Link CSS -->
  <link rel="stylesheet" href="public/css/loginStyle.css?v=<?= time() ?>">
</head>

<body>
  <div class="login-page container-fluid p-0 vh-100 d-flex align-items-center">
    <div class="login-form mx-auto d-flex flex-wrap justify-content-center">
      <img src="public/img/reset-password-bg.jpg" alt="" height="360px" class="me-0 me-sm-5">
      <div class="card border-0 align-self-start">
        <div class="card-header border-0 bg-transparent d-flex align-items-center justify-content-center">
          <p class="fs-3 fw-bold mt-3">Đặt lại mật khẩu</p>
        </div>

        <div class="card-body py-0">
          <div class="input-group rounded-3 shadow-sm mb-3">
            <i class="bx bx-lock-alt fs-4 text-primary py-3 ps-3 border-0 rounded-start-3"></i>
            <div class="form-floating">
              <input type="password" class="form-control border-0 shadow-none" id="password" placeholder="Mật khẩu">
              <label for="password">Mật khẩu</label>
            </div>
            <button class="btn eye-btn input-group-text bg-transparent border-0"><i class="bi bi-eye-slash"></i></button>
          </div>

          <div class="input-group rounded-3 shadow-sm">
            <i class="bx bx-lock-alt fs-4 text-primary py-3 ps-3 border-0 rounded-start-3"></i>
            <div class="form-floating">
              <input type="password" class="form-control border-0 shadow-none" id="repeat-password" placeholder="Xác nhận mật khẩu">
              <label for="repeat-password">Xác nhận mật khẩu</label>
            </div>
            <button class="btn eye-btn input-group-text bg-transparent border-0"><i class="bi bi-eye-slash"></i></button>
          </div>
        </div>
        <div class="card-footer border-0 bg-transparent">
          <div id="notify-error" class="text-danger mb-2">
            <i class="bi bi-exclamation-circle-fill d-none"></i>
            <span></span>
          </div>
          <button id="reset-password-submit" class="btn btn-primary w-100 mb-4">Đặt lại mật khẩu</button>
        </div>
      </div>
    </div>
  </div>
  <!-- import jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <!-- Link JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js?v=<?= time() ?>" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js?v=<?= time() ?>" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
  </script>
  <script src="public/js/loginScript.js?v=<?= time() ?>" type="text/javascript"></script>
</body>

</html>