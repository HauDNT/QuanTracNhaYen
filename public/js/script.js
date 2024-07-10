var pusher = new Pusher('ce8cd0fde22ea5ff4a20', {
  cluster: 'ap1'
});

var channel = pusher.subscribe('pusher');
channel.bind('sensor', function (data) {
  updateMap();
  updateChart();
});

channel.bind('user', function (data) {
  if (data.type == "block") {
    $.ajax({
      url: '?mod=users&action=block',
      type: 'POST',
      data: {
        account_id: data.id
      },
      success: function (data) {
        if (data == "success") {
          window.location.href = "?mod=logins&action=logout";
        }
      },
    })
  }
});

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
$("#birthday, #birthday-update, #date-start, #date-end").flatpickr({
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
      var table = $(data).find('#table').html();
      var stations_list = $(data).find('#stations-list').html();
      var pagination = $(data).find('.pagination').html();

      $('#table').html(table);
      $('#stations-list').html(stations_list);
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

  if ($('#report-position').length > 0) {
    requestData.reportPosition = $('#report-position').val();
  }

  if ($('#report-indicator').length > 0) {
    requestData.reportIndicator = $('#report-indicator').val();
  }

  if ($('#date-start').length > 0) {
    requestData.dateStart = $('#date-start').val().trim();
  }
  if ($('#date-end').length > 0) {
    requestData.dateEnd = $('#date-end').val().trim();
  }

  return requestData;
}

function requestPage(page) {
  var requestData = {
    page: page,
  };

  if ($('#search').length > 0) {
    requestData.search = $('#search').val().trim();
  }

  if ($('#sensor-status').length > 0) {
    requestData.sensorStatus = $('#sensor-status').val();
  }


  if ($('#sensor-status').length > 0) {
    requestData.sensorStatus = $('#sensor-status').val();
  }

  if ($('#user-role').length > 0) {
    requestData.userRole = $('#user-role').val();
  }

  if ($('#user-status').length > 0) {
    requestData.userStatus = $('#user-status').val();
  }

  if ($('#report-position').length > 0) {
    requestData.reportPosition = $('#report-position').val();
  }

  if ($('#report-indicator').length > 0) {
    requestData.reportIndicator = $('#report-indicator').val();
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
      search: $('#search').val().trim(),
      sensorStatus: $('#sensor-status').val().trim(),
    },
    success: function (data) {
      console.log(data);
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
  var threshold_setting = $('#addSensorModal').find('#threshold_setting').val();
  $.ajax({
    type: 'POST',
    url: '?mod=sensors&action=addSensor',
    data: {
      idSensor: idSensor,
      nameSensor: nameSensor,
      stationSensor: stationSensor,
      positionSensor: positionSensor,
      threshold_setting: threshold_setting,
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

    error: function (e) {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('hidden.bs.modal', '#addSensorModal', function () {
  $(this).find('#id_sensor').val('');
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
  var threshold_setting = $('#updateSensorModal').find('#threshold_setting').val();
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
        positionSensor: positionSensor,
        threshold_setting: threshold_setting,
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

//========================Indicator=============================
mainPage.on('click', '#add_indicator', function () {
  var indicator_name = $('#addIndicatorModal').find('#indicator_name').val().trim()
  var indicator_unit = $('#addIndicatorModal').find('#indicator_unit').val().trim()
  if (indicator_name == "" || indicator_unit == "") {
    showNotify("Vui lòng nhập đầy đủ thông tin", "warning");
  } else {
    $.ajax({
      type: "POST",
      url: '?mod=indicators&action=addIndicator',
      data: {
        indicator_name: indicator_name,
        indicator_unit: indicator_unit
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

mainPage.on('hidden.bs.modal', '#addIndicatorModal', function () {
  $(this).find('#indicator_name').val('')
  $(this).find('#indicator_unit').val('')
});

mainPage.on('click', '#view-indicator', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  $.ajax({
    type: "GET",
    url: url,
    success: function (response) {
      $('#updateIndicatorModal').html(response);
      $('#updateIndicatorModal').modal('show');
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
    }
  });
});

mainPage.on('click', '#update_indicator', function () {
  var indicator_id = $(this).val().trim();
  var indicator_name = $('#updateIndicatorModal').find('#indicator_name').val().trim()
  var indicator_unit = $('#updateIndicatorModal').find('#indicator_unit').val().trim()
  if (indicator_name == "" || indicator_unit == "") {
    showNotify("Vui lòng nhập đầy đủ thông tin", "warning");
  } else {
    $.ajax({
      type: "POST",
      url: '?mod=indicators&action=updateIndicator',
      data: {
        indicator_id: indicator_id,
        indicator_name: indicator_name,
        indicator_unit: indicator_unit
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
      search: $('#search').val().trim(),
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

//=====================================mapbox================================
if ($('#map').length > 0) {
  mapboxgl.accessToken =
    'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

  // Khởi tạo Mapbox
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    zoom: 14,
  });

  $.ajax({
    type: 'POST',
    url: '?mod=monitoring&action=getUserLocation',
    data: {
      getLocation: "true",
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        longitude = response.longitude;
        latitude = response.latitude;

        map.setCenter([longitude, latitude]);
      } else {
        map.setCenter([105.14434709756426, 9.914565453807697]);
      }
    },

    error: function () {
      map.setCenter([105.14434709756426, 9.914565453807697]);
    }
  });

  // Thêm điều khiển định vị địa lý vào bản đồ.
  map.addControl(
    new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      // Khi hoạt động, bản đồ sẽ nhận được thông tin cập nhật về vị trí của thiết bị khi nó thay đổi.
      trackUserLocation: true,
    })
  );

  // Thêm thao tác thu phóng & xoay bản đồ
  map.addControl(new mapboxgl.NavigationControl());

  var markers = [];
  const popupOffsets = {
    'top': [0, 0],
    'bottom': [0, -35],
  };

  function displayTable(data, position, station) {
    var html =
      '<p class="fw-bold my-2">Tầng ' + position + '</p>' +
      '<table id="table-map" class="table table-borderless w-100 nowrap shadow-sm mb-1 rounded-3 overflow-hidden">' +
      '<thead>' +
      '<tr>' +
      '<th class="text-start">Chỉ số</th>' +
      '<th class="text-center">Giá trị</th>' +
      '<th class="text-center">Ký hiệu</th>' +
      '</tr>' +
      '</thead>' +
      '<tbody>';
    data.forEach(element => {
      if (element["station_id"] == station["id"] && element["position"] == position) {
        html +=
          '<tr>' +
          '<td class="text-start">' + element['name'] + '</td>' +
          '<td class="text-center">' + element['value'] + '</td>' +
          '<td class="text-center">' + element['unit'] + '</td>' +
          '</tr>';
      }
    });
    html += '</tbody></table>';
    return html;
  }

  function displayData(data, position_list, station) {
    var html =
      '<ul class="popup-list-data list-inline p-0 m-0">';
    position_list.forEach(element => {
      if (element["station_id"] == station["id"]) {
        html += '<li>' + displayTable(data, element["position"], station) + '</li>';
      }
    });
    html += '</ul>';
    return html;
  }

  function updateData(data) {
    var scrollPositions = {};

    // Lưu vị trí cuộn
    markers.forEach(function (markerObj) {
      var popupElement = markerObj.popup.getElement();
      var ulElement = $(popupElement).find('ul.popup-list-data');
      if (ulElement.length) {
        scrollPositions[markerObj.marker.getLngLat()] = ulElement.scrollTop();
      }
    });

    data.station.forEach(element => {
      markers.forEach(function (markerObj) {
        var markerLngLat = markerObj.marker.getLngLat();
        if (markerLngLat.lng == element["longitude"] && markerLngLat.lat == element["latitude"]) {
          var popupElement = markerObj.popup.getElement();
          var ulElement = $(popupElement).find('ul.popup-list-data');
          var newHtml = displayData(data.sensor_value, data.position_list, element);
          ulElement.html($(newHtml).html());

          // Khôi phục vị trí cuộn
          var scrollTop = scrollPositions[markerLngLat];
          if (scrollTop !== undefined) {
            ulElement.scrollTop(scrollTop);
          }
        }
      });
    });
  }

  var station_id = null;

  function initMarkers(data) {
    data.station.forEach(element => {
      var marker = new mapboxgl.Marker()
        .setLngLat([element["longitude"], element["latitude"]])
        .addTo(map);

      var popup = new mapboxgl.Popup({ closeOnClick: false, closeButton: false, offset: popupOffsets })
        .setLngLat([element["longitude"], element["latitude"]])
        .setHTML('<p value="' + element["id"] + '" class="popup-title fw-bold text-primary border-1 border-bottom border-light-subtle w-100 m-0 py-2">' + element["name"] + '</p>' + displayData(data.sensor_value, data.position_list, element))
        .addTo(map);

      popup.getElement().addEventListener('mouseenter', function () {
        this.style.zIndex = 99;
      });

      popup.getElement().addEventListener('mouseleave', function () {
        this.style.zIndex = '';
      });

      markers.push({ marker: marker, popup: popup });

      marker.getElement().addEventListener('click', function () {
        popup.getElement().click();
      });

      popup.getElement().addEventListener('click', function () {
        station_id = $(this).find('.popup-title').attr('value');
        if ($("#box-left-map.show").length > 0) {
          bootstrap.Offcanvas.getInstance($("#box-left-map.show")[0]).hide();
          var x = $('#box-left-map').width();
          map.panBy([x, 0]);
        }
        showBoxChart(station_id);
        bootstrap.Offcanvas.getOrCreateInstance($("#box-chart-map")[0]).show();
      });
    });
  }

  function showBoxChart(id) {
    $.ajax({
      type: 'GET',
      url: '?mod=monitoring&action=showChart&id=' + id,
      success: function (data) {
        $("#box-chart-map").html(data);
        chartInit();
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    })
  }

  $("#add-location-btn").click(() => {
    add_location = !add_location;
    $("#add-location-btn").toggleClass("text-primary");
  });

  $.ajax({
    type: 'POST',
    url: '?mod=monitoring',
    data: { get_data: "true" },
    dataType: 'json',
    success: function (data) {
      initMarkers(data);
    },
    error: function () {
      alert('Không tìm thấy tọa độ!');
    }
  });

  function updateMap() {
    $.ajax({
      type: 'POST',
      url: '?mod=monitoring',
      data: { get_data: "true" },
      dataType: 'json',
      success: function (data) {
        updateData(data);
      },
      error: function () {
        alert('Không tìm thấy tọa độ!');
      }
    });
  }

  mainPage.on('click', '.station-content', function () {
    bootstrap.Offcanvas.getInstance($("#box-left-map.show")[0]).hide();
    if ($("#box-chart-map.show").length > 0) {
      bootstrap.Offcanvas.getInstance($("#box-chart-map.show")[0]).hide();
    }
    var location = $(this).data('value');
    var longitude = location.split("-")[0];
    var latitude = location.split("-")[1];
    map.flyTo({
      center: [longitude, latitude],
      essential: true
    });
  });

  var newStation = null;
  var add_location = false;

  mainPage.on('click', '#add-station-btn', function () {
    add_location = !add_location;
    if (add_location) {
      $("#add-station-btn").addClass("active");
    } else {
      $("#add-station-btn").removeClass("active");
      newStation.remove();
    }
  })

  map.on('click', function (e) {
    if (add_location) {
      var coordinates = e.lngLat;
      if (newStation !== null) {
        newStation.remove();
      }

      newStation = new mapboxgl.Marker()
        .setLngLat([coordinates.lng, coordinates.lat])
        .addTo(map);
      $('#station-longitude').val(coordinates.lng);
      $('#station-latitude').val(coordinates.lat);
      $('#addStationModal').modal("show");
    }
  });

  mainPage.on('input', '#station-longitude, #station-latitude', function () {
    var longitude = $("#station-longitude").val().trim();
    var latitude = $("#station-latitude").val().trim();
    newStation.setLngLat([longitude, latitude]);
    map.setCenter([longitude, latitude]);
  });

  mainPage.on('click', '#box-left-btn', function () {
    var x = $('#box-left-map').width();
    map.panBy([(x * -1), 0]);
    station_id = null;
  });

  mainPage.on('click', '#box-left-map .btn-close', function () {
    var x = $('#box-left-map').width();
    map.panBy([x, 0]);
  });

  mainPage.on('click', '#box-chart-map .btn-close', function () {
    station_id = null;
  });

  $(window).on('resize', function () {
    if ($('#box-left-map').hasClass("hiding")) {
      var x = $('#box-left-map').width();
      map.panBy([x, 0]);
    }
    station_id = null;
  });

  mainPage.on('hidden.bs.modal', '#addStationModal', function () {
    $("#addStationModal").find("#station-name").val("");
    $("#addStationModal").find("#station-longitude").val("");
    $("#addStationModal").find("#station-latitude").val("");
    $("#addStationModal").find("#station-address").val("");
    $("#addStationModal").find("#station-url").val("");
    $("#addStationModal").find("#station_user option:first").prop('selected', true);
    newStation.remove();
  });

  mainPage.on('click', '#add_station', function () {
    var name = $("#addStationModal").find("#station-name").val().trim();
    var longitude = $("#addStationModal").find("#station-longitude").val().trim();
    var latitude = $("#addStationModal").find("#station-latitude").val().trim();
    var address = $("#addStationModal").find("#station-address").val().trim();
    var user = $("#addStationModal").find("#station_user").val();

    $.ajax({
      type: 'POST',
      url: '?mod=monitoring&action=addStation',
      data: {
        name: name,
        longitude: longitude,
        latitude: latitude,
        address: address,
        user: user
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
  })

  mainPage.on('click', '#update_station', function () {
    var id = $(this).val().trim();
    var name = $("#updateStationModal").find("#station-name").val().trim();
    var longitude = $("#updateStationModal").find("#station-longitude").val().trim();
    var latitude = $("#updateStationModal").find("#station-latitude").val().trim();
    var address = $("#updateStationModal").find("#station-address").val().trim();
    var urlWeb = $("#updateStationModal").find("#station-url").val().trim();
    var user = $("#updateStationModal").find("#station_user").val();

    $.ajax({
      type: 'POST',
      url: '?mod=monitoring&action=updateStation',
      data: {
        id: id,
        name: name,
        longitude: longitude,
        latitude: latitude,
        address: address,
        urlWeb: urlWeb,
        user: user
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
  })

  mainPage.on('click', '#view-station', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      type: "GET",
      url: url,
      success: function (response) {
        $('#updateStationModal').html(response);
        $('#updateStationModal').modal('show');
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
      }
    });
  });

  mainPage.on('click', '#station-setting', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
      type: "GET",
      url: url,
      success: function (response) {
        if (response != "") {
          $('#settingStationModal').html(response);
          $('#settingStationModal').modal('show');
          mainPage.find("#time-start, #time-finish").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
          });
        }
      },

      error: function () {
        showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
      }
    });
  });

  //==============================chart & map===================================
  var lineChart = null;
  var barChart = null;
  var colorList = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'];

  function chartInit() {
    $.ajax({
      type: "POST",
      url: "?mod=monitoring&action=showChart",
      data: {
        station_id: station_id,
        position: $("#box-chart-map").find("#position").val()
      },
      dataType: 'json',
      success: function (response) {
        const labels = [];
        const datasets = [];
        for (var i = response.label.length - 1; i >= 0; i--) {
          labels.push(response.label[i]["createdAt"].split(" ").pop());
        }

        var indexColor = 0;
        response.legend.forEach(element => {
          var data = [];
          response.data.forEach(element2 => {
            if (element2["name"] == element["name"]) {
              data.push(element2["value"]);
            }
          });
          datasets.push({
            label: element["name"],
            data: data,
            backgroundColor: colorList[indexColor],
            borderColor: colorList[indexColor],
          });
          indexColor++;
          if (indexColor == colorList.length) {
            indexColor = 0;
          }
        });

        const data = {
          labels: labels,
          datasets: datasets
        };

        const customLegend = {
          id: 'customLegend',
          afterDraw: (chart, args, option) => {
            const { _metasets, ctx } = chart;
            ctx.save();
            _metasets.forEach((meta) => {
              ctx.font = 'bolder 12px Arial';
              ctx.fillStyle = meta._dataset.borderColor;
              ctx.textBaseline = 'middle';
              ctx.fillText(meta._dataset.label, meta.data[meta.data.length - 1].x + 6, meta.data[meta.data.length - 1].y)
            });
          }
        }

        const lineConfig = {
          type: 'line',
          data: data,
          options: {
            maintainAspectRatio: false,
            responsive: true,
            layout: {
              padding: {
                right: 100
              }
            },
            plugins: {
              legend: {
                display: false
              }
            },
            tension: 0.4,
            scales: {
              x: {
                ticks: {
                  color: '#6C757D'
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                }
              },

              y: {
                ticks: {
                  color: '#6C757D'
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                },
                beginAtZero: true
              }
            }
          },
          plugins: [customLegend]
        };

        const barConfig = {
          type: 'bar',
          data: data,
          options: {
            maintainAspectRatio: false,
            responsive: true,
            maxBarThickness: 36,
            plugins: {
              legend: {
                display: false
              }
            },
            tension: 0.4,
            scales: {
              x: {
                stacked: true,
                ticks: {
                  color: '#6C757D'
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                }
              },

              y: {
                stacked: true,
                ticks: {
                  color: '#6C757D'
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                },
                beginAtZero: true
              }
            }
          },
        };

        if ($("#lineChart").length > 0 && $("#barChart").length > 0) {
          lineChart = new Chart($("#lineChart"), lineConfig);
          barChart = new Chart($("#barChart"), barConfig);
        }
      },
    });
  }

  mainPage.on('change', "#box-chart-map #position", function () {
    $.ajax({
      type: "POST",
      url: "?mod=monitoring&action=showChart",
      data: {
        station_id: station_id,
        position: $("#box-chart-map").find("#position").val()
      },
      dataType: 'json',
      success: function (response) {
        const labels = [];
        const datasets = [];
        for (var i = response.label.length - 1; i >= 0; i--) {
          labels.push(response.label[i]["createdAt"].split(" ").pop());
        }

        var indexColor = 2;
        response.legend.forEach(element => {
          var data = [];
          response.data.forEach(element2 => {
            if (element2["name"] == element["name"]) {
              data.push(element2["value"]);
            }
          });
          datasets.push({
            label: element["name"],
            data: data,
            backgroundColor: colorList[indexColor],
            borderColor: colorList[indexColor],
          });
          indexColor++;
          if (indexColor == colorList.length) {
            indexColor = 0;
          }
        });

        if ($("#lineChart").length > 0 && $("#barChart").length > 0) {
          lineChart.data.labels = labels;
          lineChart.data.datasets = datasets;

          barChart.data.labels = labels;
          barChart.data.datasets = datasets;

          lineChart.update();
          barChart.update();
        }
      },
    });
  });

  function updateChart() {
    $.ajax({
      type: "POST",
      url: "?mod=monitoring&action=showChart",
      data: {
        station_id: station_id,
        position: $("#box-chart-map").find("#position").val()
      },
      dataType: 'json',
      success: function (response) {
        const labels = [];
        const datasets = [];
        for (var i = response.label.length - 1; i >= 0; i--) {
          labels.push(response.label[i]["createdAt"].split(" ").pop());
        }

        var indexColor = 2;
        response.legend.forEach(element => {
          var data = [];
          response.data.forEach(element2 => {
            if (element2["name"] == element["name"]) {
              data.push(element2["value"]);
            }
          });
          datasets.push({
            label: element["name"],
            data: data,
            backgroundColor: colorList[indexColor],
            borderColor: colorList[indexColor],
          });
          indexColor++;
          if (indexColor == colorList.length) {
            indexColor = 0;
          }
        });

        if (response.label.length >= 4) {
          var indexLine = 0;
          lineChart.data.datasets.forEach(element => {
            var setData = [];
            response.data.forEach(element2 => {
              if (element2.name == response.legend[indexLine].name) {
                setData.push(element2.value);
              }
            });
            element.data = setData;
            indexLine++;
          });
        }

        if ($("#lineChart").length > 0 && $("#barChart").length > 0) {
          lineChart.data.labels = labels;

          if (response.label.length < 4) {
            lineChart.data.datasets = datasets;
          }

          barChart.data.labels = labels;
          if (response.label.length < 4) {
            barChart.data.datasets = datasets;
          }

          lineChart.update();
          barChart.update();
        }
      },
    });
  }
}

//======================================Setting===============================
mainPage.on('change', '#avatar', function () {
  var fileInput = $(this)[0];
  var avatar = fileInput.files[0];
  var formData = new FormData();
  formData.append('avatar', avatar);
  $.ajax({
    type: "POST",
    url: "?mod=personal&action=updateAvatar",
    data: formData,
    contentType: false,
    processData: false,
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

mainPage.on('click', '#change-password-submit', function () {
  var oldPass = $('.change_password-form').find('#InputPasswordOld').val().trim();
  var newPass = $('.change_password-form').find('#InputPassword1').val().trim();
  var confirmPass = $('.change_password-form').find('#InputPassword2').val().trim();
  $.ajax({
    type: "POST",
    url: "?mod=change_password&action=updatePassword",
    data: {
      oldPass: oldPass,
      newPass: newPass,
      confirmPass: confirmPass
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        setNotifySession(response.message, response.notifyType);
        window.location.reload();
      } else if (response.type == 'fail') {
        $("#notify-error i").removeClass("d-none");
        $("#notify-error span").text(response.message);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
    }
  });
});

mainPage.on('keypress', '#InputPasswordOld', function (event) {
  if (event.which === 13) {
    $('#InputPassword1').focus();
  }
});

mainPage.on('keypress', '#InputPassword1', function (event) {
  if (event.which === 13) {
    $('#InputPassword2').focus();
  }
});

mainPage.on('keypress', '#InputPassword2', function (event) {
  if (event.which === 13) {
    $('#change-password-submit').click();
  }
});

mainPage.on('click', '#update-info-submit', function () {
  var full_name = $(".info-form").find("#full_name").val().trim();
  var gender = $(".info-form").find("#gender").val();
  var birthday = $(".info-form").find("#birthday").val().trim();

  $.ajax({
    type: 'POST',
    url: '?mod=personal&action=updateInfo',
    data: {
      full_name: full_name,
      gender: gender,
      birthday: birthday
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
})

//==========================station setting=============================

mainPage.on("input", "#temp_thres_min_range", function () {
  var temp_thres_min = $(this).val();
  $("#temp_thres_min").val(temp_thres_min);
})

mainPage.on("input", "#temp_thres_max_range", function () {
  var temp_thres_max = $(this).val();
  $("#temp_thres_max").val(temp_thres_max);
})

mainPage.on("input", "#temp_thres_min", function () {
  var temp_thres_min = $(this).val();
  $("#temp_thres_min_range").val(temp_thres_min);
})

mainPage.on("input", "#temp_thres_max", function () {
  var temp_thres_max = $(this).val();
  $("#temp_thres_max_range").val(temp_thres_max);
})

mainPage.on("input", "#humid_thres_min_range", function () {
  var humid_thres_min = $(this).val();
  $("#humid_thres_min").val(humid_thres_min);
})

mainPage.on("input", "#humid_thres_max_range", function () {
  var humid_thres_max = $(this).val();
  $("#humid_thres_max").val(humid_thres_max);
})

mainPage.on("input", "#humid_thres_min", function () {
  var humid_thres_min = $(this).val();
  $("#humid_thres_min_range").val(humid_thres_min);
})

mainPage.on("input", "#humid_thres_max", function () {
  var humid_thres_max = $(this).val();
  $("#humid_thres_max_range").val(humid_thres_max);
})

mainPage.on("change", "#settingStationModal #position", function () {
  var id = $("#settingStationModal").find(".modal-content").attr("value");
  var position = $(this).val();
  $.ajax({
    type: "POST",
    url: "?mod=monitoring&action=settingStation",
    data: {
      id: id,
      position: position
    },
    success: function (response) {
      $('#settingStationModal').html(response);
      mainPage.find("#time-start, #time-finish").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
      });
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
    }
  });
});

mainPage.on("input", "#settingStationModal #turn_mist_spray", function () {
  var id = $(this).attr("data");
  var status = $(this).is(':checked') ? 1 : 0;
  $.ajax({
    type: "POST",
    url: "?mod=monitoring&action=updateMotor",
    data: {
      id: id,
      status: status
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        // showNotify(response.message, response.notifyType);
      } else if (response.type == 'fail') {
        showNotify(response.message, response.notifyType);
        $("#settingStationModal").find("#turn_mist_spray").is(':checked') ? $("#settingStationModal").find("#turn_mist_spray").prop('checked', false) : $("#settingStationModal").find("#turn_mist_spray").prop('checked', true);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        $("#settingStationModal").find("#turn_mist_spray").is(':checked') ? $("#settingStationModal").find("#turn_mist_spray").prop('checked', false) : $("#settingStationModal").find("#turn_mist_spray").prop('checked', true);
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
      $("#settingStationModal").find("#turn_mist_spray").is(':checked') ? $("#settingStationModal").find("#turn_mist_spray").prop('checked', false) : $("#settingStationModal").find("#turn_mist_spray").prop('checked', true);
    }
  });
});

mainPage.on('click', '#setting_station_save', function () {
  var station_id = $("#settingStationModal").find(".modal-content").attr("value");
  var sensor_id = $(this).val();
  var time_start = $("#time-start").val().trim();
  var time_finish = $("#time-finish").val().trim();
  var temp_thres_min = $("#temp_thres_min").val();
  var temp_thres_max = $("#temp_thres_max").val();
  var humid_thres_min = $("#humid_thres_min").val();
  var humid_thres_max = $("#humid_thres_max").val();
  var send_data = $("#send_data").val();
  var send_email = $("#send_email").val();
  var sender_email = $("#email").val().trim();
  var sender_password = $("#password").val().trim();
  $.ajax({
    type: "POST",
    url: "?mod=monitoring&action=updateStationSetting",
    data: {
      station_id: station_id,
      sensor_id: sensor_id,
      time_start: time_start,
      time_finish: time_finish,
      temp_thres_min: temp_thres_min,
      temp_thres_max: temp_thres_max,
      humid_thres_min: humid_thres_min,
      humid_thres_max: humid_thres_max,
      send_data: send_data,
      send_email: send_email,
      sender_email: sender_email,
      sender_password: sender_password
    },
    dataType: 'json',
    success: function (response) {
      if (response.type == 'success') {
        showNotify(response.message, response.notifyType);
      } else if (response.type == 'fail') {
        showNotify(response.message, response.notifyType);
      } else {
        showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
      }
    },

    error: function () {
      showNotify("Lỗi hệ thống vui lòng thử lại sau!", "danger");
    }
  });
});

//==================================report=================================
if ($("#report-lineChart").length > 0) {
  var report_lineChart = null;
  var colorList = ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'];

  function reportChartInit() {
    $.ajax({
      type: "POST",
      url: "?mod=report&action=getChart",
      data: {
        date: "month"
      },
      dataType: 'json',
      success: function (response) {
        const labels = [];
        const datasets = [];
        var indexColor = 0;
        response.label.forEach(element => {
          if (element["month"]) {
            labels.push(element["month"]);
          } else if (element["weekdays"]) {
            labels.push((parseInt(element["weekdays"]) + 1) != 8 ? ("T" + (parseInt(element["weekdays"]) + 1)) : "CN");
          }
        })

        response.legend.forEach(element => {
          var data = [];
          response.data.forEach(element2 => {
            if (element2["indicator_name"] == element["name"]) {
              data.push(element2["average_value"]);
            }
          });
          datasets.push({
            label: element["name"],
            data: data,
            backgroundColor: colorList[indexColor],
            borderColor: colorList[indexColor],
          });
          indexColor++;
          if (indexColor == colorList.length) {
            indexColor = 0;
          }
        });

        const data = {
          labels: labels,
          datasets: datasets,
        };

        const lineConfig = {
          type: 'line',
          data: data,
          options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            tension: 0.4,
            scales: {
              x: {
                ticks: {
                  color: '#6C757D',
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                }
              },

              y: {
                ticks: {
                  color: '#6C757D',
                },
                grid: {
                  display: false
                },
                border: {
                  display: false
                }
              }
            }
          },
        };

        if ($("#report-lineChart").length > 0) {
          report_lineChart = new Chart($("#report-lineChart"), lineConfig);
        }
      },
    });
  }

  reportChartInit();

  mainPage.on('change', '#chart-date', function () {
    var filter = $(this).val();
    $.ajax({
      type: "POST",
      url: "?mod=report&action=getChart",
      data: {
        date: filter
      },
      dataType: 'json',
      success: function (response) {
        const labels = [];
        const datasets = [];
        var indexColor = 0;
        response.label.forEach(element => {
          if (element["month"]) {
            labels.push(element["month"]);
          } else if (element["weekdays"]) {
            labels.push((parseInt(element["weekdays"]) + 1) != 8 ? ("T" + (parseInt(element["weekdays"]) + 1)) : "CN");
          }
        })

        response.legend.forEach(element => {
          var data = [];
          response.data.forEach(element2 => {
            if (element2["indicator_name"] == element["name"]) {
              data.push(element2["average_value"]);
            }
          });
          datasets.push({
            label: element["name"],
            data: data,
            backgroundColor: colorList[indexColor],
            borderColor: colorList[indexColor],
          });
          indexColor++;
          if (indexColor == colorList.length) {
            indexColor = 0;
          }
        });

        if ($("#report-lineChart").length > 0) {
          report_lineChart.data.labels = labels;
          report_lineChart.data.datasets = datasets;
          report_lineChart.update();
        }
      },
    });
  })

  mainPage.on('change', '#report-position, #report-indicator, #date-start, #date-end', function () {
    $.ajax({
      type: 'POST',
      url: window.location.href,
      data: {
        search: $('#search').val().trim(),
        reportPosition: $('#report-position').val(),
        reportIndicator: $('#report-indicator').val(),
        dateStart: $('#date-start').val().trim(),
        dateEnd: $('#date-end').val().trim(),
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
}