var loginPage = $('.login-page');

loginPage.on('click', '.eye-btn', function () {
  var input = $(this).siblings('.form-floating').find('input');
  if (input.prop('type') == 'password') {
    input.prop('type', 'text');
    $(this).html('<i class="bi bi-eye"></i>');
  } else {
    input.prop('type', 'password');
    $(this).html('<i class="bi bi-eye-slash"></i>');
  }
});

loginPage.on('click', '#sign-in-submit', function () {
  var username = $(".login-form").find("#username").val().trim();
  var password = $(".login-form").find("#password").val().trim();
  $.ajax({
    url: "?mod=logins&action=login",
    type: "POST",
    data: {
      username: username,
      password: password
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == "success") {
        window.location.href = response.url;
      } else if (response.type == "fail") {
        $("#notify-error i").removeClass("d-none");
        $("#notify-error span").text(response.message);
      } else {
        $("#notify-error i").removeClass("d-none");
        $("#notify-error span").text("Lỗi hệ thống vui lòng thử lại sau.");
      }
    },

    error: function () {
      $("#notify-error i").removeClass("d-none");
      $("#notify-error span").text("Lỗi hệ thống vui lòng thử lại sau.");
    }
  });
});

loginPage.on('keypress', '#username', function (event) {
  if (event.which === 13) {
    $('#password').focus();
  }
});

loginPage.on('keypress', '#password', function (event) {
  if (event.which === 13) {
    $('#sign-in-submit').click();
  }
});

loginPage.on('click', '#forgot-password-send', function () {
  var email = $(".login-form").find("#email").val().trim();
  $.ajax({
    url: "?mod=forgot_password&action=resetPassword",
    type: "POST",
    data: {
      email: email,
    },
    dataType: 'json',
    success: function (response) {
      $("#notify-error i, #notify-success i").addClass("d-none");
      $("#notify-error span, #notify-success span").text("");
      if (response.type == "success") {
        $("#notify-success i").removeClass("d-none");
        $("#notify-success span").text(response.message);
      } else if (response.type == "fail") {
        $("#notify-error i").removeClass("d-none");
        $("#notify-error span").text(response.message);
      } else {
        $("#notify-error i").removeClass("d-none");
        $("#notify-error span").text("Lỗi hệ thống vui lòng thử lại sau.");
      }
    },

    error: function (e) {
      $("#notify-error i").removeClass("d-none");
      $("#notify-error span").text("Lỗi hệ thống vui lòng thử lại sau.");
    }
  });
});

loginPage.on('keypress', '#email', function (event) {
  if (event.which === 13) {
    $('#forgot-password-send').click();
  }
});