function showNotify(message, type) {
  $('#notify').removeClass("text-bg-info");
  $('#notify').removeClass("text-bg-success");
  $('#notify').removeClass("text-bg-warning");
  $('#notify').removeClass("text-bg-danger");
  var icon = "";

  switch (type) {
    case 'info': {
      $('#notify').addClass("text-bg-info");
      icon = '<i class="bi bi-info-circle me-2"></i>';
      break;
    }

    case 'success': {
      $('#notify').addClass("text-bg-success");
      icon = '<i class="bi bi-check-lg me-2"></i>';
      break;
    }

    case 'warning': {
      $('#notify').addClass("text-bg-warning");
      icon = '<i class="bi bi-exclamation-triangle me-2"></i>';
      break;
    }

    case 'danger': {
      $('#notify').addClass("text-bg-danger");
      icon = '<i class="bi bi-x-circle me-2"></i>';
      break;
    }
  }

  $('#notify').find('.toast-body').html(icon + message);
  bootstrap.Toast.getOrCreateInstance($('#notify')).show();
}

function setNotifySession(message, type) {
  sessionStorage.setItem('notify', JSON.stringify([
    {
      type: type,
      message: message,
    }
  ]));
}

// showNotify("text", "success");

//========================Flatpickr=============================
$("#birthday, #birthday-update").flatpickr({
  dateFormat: "d-m-Y",
});

//========================Notify=============================
let storedData = sessionStorage.getItem('notify');
if (storedData) {
  let notify = JSON.parse(storedData);
  showNotify(notify[0].message, notify[0].type);
  sessionStorage.removeItem('notify');
}

if (sessionStorage.getItem('update')) {
  showNotify("Cập nhật thành công.", "success");
  sessionStorage.removeItem('update');
}

var mainPage = $('.main-page');

mainPage.on('click', ".page-link", function (e) {
  e.preventDefault();
  var page = $(this).attr('href');
  $.ajax({
    type: "POST",
    url: window.location.href,
    data: requestPage(page),
    success: function (data) {
      var value = $(data).find('#table').html();
      var pagination = $(data).find('.pagination').html();
      $('#table').html(value);
      $('.pagination').html(pagination);

    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
})

mainPage.on('input', '#search', function () {
  $.ajax({
    type: 'POST',
    url: window.location.href,
    data: requestSearch(),
    success: function (data) {
      var showing = $(data).find('.showing').html();
      var value = $(data).find('#table').html();
      var pagination = $(data).find('.pagination').html();
      $('.showing').html(showing);
      $('#table').html(value);
      $('.pagination').html(pagination);
    },
    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

function requestSearch() {
  var requestData = {
    search: $('#search').val().trim(),
  };

  if ($('#sensor-status').length > 0) {
    requestData.sensorStatus = $('#sensor-status').val();
  }

  if ($('#user-role').length > 0) {
    requestData.userRole = $('#user-role').val();
  }

  if ($('#user-status').length > 0) {
    requestData.userStatus = $('#user-status').val();
  }

  return requestData;
}

function requestPage(page) {
  var requestData = {
    page: page,
    search: $('.search').val().trim(),
  };

  if ($('#sensor-status').length > 0) {
    requestData.sensorStatus = $('#sensor-status').val();
  }

  return requestData;
}

mainPage.on('click', '.eye-btn', function () {
  var input = $(this).siblings('input');
  if (input.prop('type') == 'password') {
    input.prop('type', 'text');
    $(this).html('<i class="bi bi-eye"></i>');
  } else {
    input.prop('type', 'password');
    $(this).html('<i class="bi bi-eye-slash"></i>');
  }
});

//========================sensor=============================

mainPage.on('change', '#sensor-status', function () {
  $.ajax({
    type: 'POST',
    url: window.location.href,
    data: {
      search: $('.search').val().trim(),
      status: $('#sensor-status').val().trim(),
    },
    success: function (data) {
      var value = $(data).find('#table').html();
      var pagination = $(data).find('.pagination').html();
      $('#table').html(value);
      $('.pagination').html(pagination);
    },
    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('click', '#add_sensor', function () {
  var idSensor = $('#addSensorModal').find('#id_sensor').val();
  var nameSensor = $('#addSensorModal').find('#name_sensor').val();
  var stationSensor = $('#addSensorModal').find('#station_sensor').val();
  var positionSensor = $('#addSensorModal').find('#position_sensor').val();
  $.ajax({
    type: 'POST',
    url: '?mod=sensors&action=addSensor',
    data: {
      idSensor: idSensor,
      nameSensor: nameSensor,
      stationSensor: stationSensor,
      positionSensor: positionSensor
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        setNotifySession(response.message, response.notifyType);
        window.location.reload();
      } else if (response.type == 'fail') {
        showNotify(response.message, response.notifyType);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('hidden.bs.modal', '#addSensorModal', function () {
  $(this).find('#id_sensor').val('1');
  $(this).find('#name_sensor').val('');
  $(this).find('#station_sensor option:first').prop('selected', true);
  $(this).find('#position_sensor').val('1');
});

mainPage.on('click', '#view-sensor', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  $.ajax({
    type: 'GET',
    url: url,
    success: function (response) {
      $('#updateSensorModal').html(response);
      $('#updateSensorModal').modal('show');
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('click', '#update_sensor', function () {
  var idSensor = $('#updateSensorModal').find('#id_sensor').val();
  var nameSensor = $('#updateSensorModal').find('#name_sensor').val();
  var stationSensor = $('#updateSensorModal').find('#station_sensor').val();
  var positionSensor = $('#updateSensorModal').find('#position_sensor').val();
  if (idSensor.trim() == '' || nameSensor.trim() == '' || stationSensor == null || positionSensor.trim() == '') {
    showNotify("Vui lòng nhập đầy đủ thông tin.", "warning");
  } else {
    $.ajax({
      type: 'POST',
      url: '?mod=sensors&action=updateSensor',
      data: {
        idSensor: idSensor,
        nameSensor: nameSensor,
        stationSensor: stationSensor,
        positionSensor: positionSensor
      },

      dataType: 'json',
      success: function (response) {
        if (response.type == 'success') {
          setNotifySession(response.message, response.notifyType);
          window.location.reload();
        } else if (response.type == 'fail') {
          showNotify(response.message, response.notifyType);
        } else {
          showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    });
  }
});

//========================Unit=============================
mainPage.on('click', '#add_unit', function () {
  var unit_name = $('#addUnitModal').find('#unit_name').val().trim()
  var unit_symbol = $('#addUnitModal').find('#unit_symbol').val().trim()
  if (unit_name == "" || unit_symbol == "") {
    showNotify("Vui lòng nhập đầy đủ thông tin", "warning");
  } else {
    $.ajax({
      type: "POST",
      url: '?mod=units&action=addUnit',
      data: {
        unit_name: unit_name,
        unit_symbol: unit_symbol
      },
      dataType: 'json',
      success: function (response) {
        if (response.type == 'success') {
          setNotifySession(response.message, response.notifyType);
          window.location.reload();
        } else if (response.type == 'fail') {
          showNotify(response.message, response.notifyType);
        } else {
          showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    })
  }
});

mainPage.on('hidden.bs.modal', '#addUnitModal', function () {
  $(this).find('#unit_name').val('')
  $(this).find('#unit_symbol').val('')
});

mainPage.on('click', '#view-unit', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  $.ajax({
    type: "GET",
    url: url,
    success: function (response) {
      $('#updateUnitModal').html(response);
      $('#updateUnitModal').modal('show');
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
    }
  });
});

mainPage.on('click', '#update_unit', function () {
  var unit_id = $(this).val().trim();
  var unit_name = $('#updateUnitModal').find('#unit_name').val().trim()
  var unit_symbol = $('#updateUnitModal').find('#unit_symbol').val().trim()
  if (unit_name == "" || unit_symbol == "") {
    showNotify("Vui lòng nhập đầy đủ thông tin", "warning");
  } else {
    $.ajax({
      type: "POST",
      url: '?mod=units&action=updateUnit',
      data: {
        unit_id: unit_id,
        unit_name: unit_name,
        unit_symbol: unit_symbol
      },
      dataType: 'json',
      success: function (response) {
        if (response.type == 'success') {
          setNotifySession(response.message, response.notifyType);
          window.location.reload();
        } else if (response.type == 'fail') {
          showNotify(response.message, response.notifyType);
        } else {
          showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    })
  }
});

mainPage.on('change', '#user-role, #user-status', function () {
  $.ajax({
    type: 'POST',
    url: window.location.href,
    data: {
      search: $('.search').val().trim(),
      userRole: $('#user-role').val(),
      userStatus: $('#user-status').val(),
    },
    success: function (data) {
      var value = $(data).find('#table').html();
      var pagination = $(data).find('.pagination').html();
      $('#table').html(value);
      $('.pagination').html(pagination);
    },
    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

//========================User=============================
mainPage.on('hidden.bs.modal', '#addUserModal', function () {
  $(this).find('#full_name').val('');
  $(this).find('#username').val('');
  $(this).find('#password').val('');
  $(this).find('#repeat_password').val('');
  $(this).find('#email').val('');
  $(this).find('#phone_number').val('');
  $(this).find('#birthday').val('');
  $(this).find('#gender option:first').prop('selected', true);
  $(this).find('#role option:first').prop('selected', true);
});

mainPage.on('click', '#add_user', function () {
  var full_name = $('#addUserModal').find('#full_name').val().trim();
  var username = $('#addUserModal').find('#username').val().trim();
  var password = $('#addUserModal').find('#password').val().trim();
  var repeat_password = $('#addUserModal').find('#repeat_password').val().trim();
  var email = $('#addUserModal').find('#email').val().trim();
  var phone_number = $('#addUserModal').find('#phone_number').val().trim();
  var birthday = $('#addUserModal').find('#birthday').val().trim();
  var gender = $('#addUserModal').find('#gender').val();
  var role = $('#addUserModal').find('#role').val();
  $.ajax({
    type: 'POST',
    url: '?mod=users&action=addUser',
    data: {
      full_name: full_name,
      username: username,
      password: password,
      repeat_password: repeat_password,
      email: email,
      phone_number: phone_number,
      birthday: birthday,
      gender: gender,
      role: role
    },
    dataType: 'json',
    success: function (response) {
      console.log(response);
      if (response.type == 'success') {
        setNotifySession(response.message, response.notifyType);
        window.location.reload();
      } else if (response.type == 'fail') {
        showNotify(response.message, response.notifyType);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('click', '#view-user', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  $.ajax({
    type: "GET",
    url: url,
    success: function (response) {
      $('#updateUserModal').html(response);
      flatpickr("#birthday-update", {
        dateFormat: "d-m-Y",
      });
      $('#updateUserModal').modal('show');
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
    }
  });
});

mainPage.on('click', '#update_user', function () {
  var account_id = $(this).val().trim();
  var full_name = $('#updateUserModal').find('#full_name').val().trim();
  var password = $('#updateUserModal').find('#password').val().trim();
  var repeat_password = $('#updateUserModal').find('#repeat_password').val().trim();
  var email = $('#updateUserModal').find('#email').val().trim();
  var phone_number = $('#updateUserModal').find('#phone_number').val().trim();
  var birthday = $('#updateUserModal').find('#birthday-update').val().trim();
  var gender = $('#updateUserModal').find('#gender').val();
  var role = $('#updateUserModal').find('#role').val();
  var status = $('#updateUserModal').find('#status').val();
  $.ajax({
    type: 'POST',
    url: '?mod=users&action=updateUser',
    data: {
      account_id: account_id,
      full_name: full_name,
      password: password,
      repeat_password: repeat_password,
      email: email,
      phone_number: phone_number,
      birthday: birthday,
      gender: gender,
      role: role,
      status: status
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        setNotifySession(response.message, response.notifyType);
        window.location.reload();
      } else if (response.type == 'fail') {
        showNotify(response.message, response.notifyType);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});