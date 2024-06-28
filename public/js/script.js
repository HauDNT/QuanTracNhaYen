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

// showNotify("text", "success");

//========================Notify=============================
if (sessionStorage.getItem('add')) {
  showNotify("Thêm mới thành công.", "success");
  sessionStorage.removeItem('add');
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

mainPage.on('input', '.search', function () {
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
    search: $('.search').val().trim(),
  };

  if ($('#sensor-status').length > 0) {
    requestData.sensorStatus = $('#sensor-status').val();
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
  if (idSensor.trim() == '' || nameSensor.trim() == '' || stationSensor == null || positionSensor.trim() == '') {
    showNotify("Vui lòng nhập đầy đủ thông tin.", "warning");
  } else {
    $.ajax({
      type: 'POST',
      url: '?mod=sensors&action=addSensor',
      data: {
        idSensor: idSensor,
        nameSensor: nameSensor,
        stationSensor: stationSensor,
        positionSensor: positionSensor
      },

      success: function (response) {
        if (response == 'success') {
          sessionStorage.setItem('add', 'success');
          window.location.reload();
        } else if (response == 'fail') {
          showNotify("Thêm mới thất bại.", "danger");
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

mainPage.on('hidden.bs.modal', '#addSensorModal', function () {
  $('#addSensorModal').find('#id_sensor').val('1');
  $('#addSensorModal').find('#name_sensor').val('');
  $('#addSensorModal').find('#station_sensor option:first').prop('selected', true);
  $('#addSensorModal').find('#position_sensor').val('1');
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

      success: function (response) {
        if (response == 'success') {
          sessionStorage.setItem('update', 'success');
          window.location.reload();
        } else if (response == 'fail') {
          showNotify("Cập nhật thất bại.", "danger");
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
mainPage.on('input', '#search-unit', function () {
  var searchQuery = $(this).val();
  $.ajax({
    type: 'POST',
    url: window.location.href,
    data: {
      search: searchQuery,
    },
    success: function (data) {
      var value = $(data).find('#table').html();
      $('#table').html(value);
    },
    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "warning");
    }
  });
});

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
      success: function (response) {
        console.log(response);
        if (response == 'success') {
          sessionStorage.setItem('add', 'success');
          window.location.reload();
        } else if (response == 'fail') {
          showNotify("Thêm thất bại.", "danger");
        } else {
          showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
      },
      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
      }
    })
  }
});

mainPage.on('hidden.bs.modal', '#addUnitModal', function () {
  $('#addUnitModal').find('#unit_name').val('')
  $('#addUnitModal').find('#unit_symbol').val('')
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
      success: function (response) {
        console.log(response);
        if (response == 'success') {
          sessionStorage.setItem('update', 'success');
          window.location.reload();
        } else if (response == 'fail') {
          showNotify("Cập nhật thất bại.", "danger");
        } else {
          showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
      },
      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
      }
    })
  }
})