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
      var table = $(data).find('#table').html();
      var stations_list = $(data).find('#stations-list').html();
      var pagination = $(data).find('.pagination').html();
      $('.showing').html(showing);
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

  return requestData;
}

function requestPage(page) {
  var requestData = {
    page: page,
    search: $('#search').val().trim(),
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
      search: $('#search').val().trim(),
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

//=====================================mapbox================================
if ($('#map').length > 0) {
  mapboxgl.accessToken =
    'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

  // Khởi tạo Mapbox
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [105.14434709756426, 9.914565453807697],
    zoom: 14,
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
      '<table id="table-map" class="table table-hover table-borderless w-100 nowrap shadow-sm mb-1 rounded-3 overflow-hidden">' +
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
        if (markerLngLat.lng === element["longitude"] && markerLngLat.lat === element["latitude"]) {
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
        if ($("#box-left-map.show").length > 0) {
          bootstrap.Offcanvas.getInstance($("#box-left-map.show")[0]).hide();
          var x = $('#box-left-map').width();
          map.panBy([x, 0]);
        }
        bootstrap.Offcanvas.getOrCreateInstance($("#box-bottom-map")[0]).show();
      });
    });
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

  function update() {
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
    if ($("#box-bottom-map.show").length > 0) {
      bootstrap.Offcanvas.getInstance($("#box-bottom-map.show")[0]).hide();
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
  // setInterval(() => {
  //   update();
  //   console.log("2");
  // }, 1000);

  mainPage.on('click', '#box-left-btn', function () {
    var x = $('#box-left-map').width();
    map.panBy([(x * -1), 0]);
  });

  mainPage.on('click', '#box-left-map .btn-close', function () {
    var x = $('#box-left-map').width();
    map.panBy([x, 0]);
  });

  $(window).on('resize', function () {
    if ($('#box-left-map').hasClass("hiding")) {
      var x = $('#box-left-map').width();
      map.panBy([x, 0]);
    }
  });

  mainPage.on('hidden.bs.modal', '#addStationModal', function () {
    $("#addStationModal").find("#station-name").val("");
    $("#addStationModal").find("#station-longitude").val("");
    $("#addStationModal").find("#station-latitude").val("");
    $("#addStationModal").find("#station-url").val("");
    $("#addStationModal").find("#station_user option:first").prop('selected', true);
    newStation.remove();
  });

  mainPage.on('click', '#add_station', function () {
    var name = $("#addStationModal").find("#station-name").val().trim();
    var longitude = $("#addStationModal").find("#station-longitude").val().trim();
    var latitude = $("#addStationModal").find("#station-latitude").val().trim();
    var urlWeb = $("#addStationModal").find("#station-url").val().trim();
    var user = $("#addStationModal").find("#station_user").val();

    $.ajax({
      type: 'POST',
      url: '?mod=monitoring&action=addStation',
      data: {
        name: name,
        longitude: longitude,
        latitude: latitude,
        urlWeb: urlWeb,
        user: user
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
  })

  mainPage.on('click', '#update_station', function () {
    var id = $(this).val().trim();
    var name = $("#updateStationModal").find("#station-name").val().trim();
    var longitude = $("#updateStationModal").find("#station-longitude").val().trim();
    var latitude = $("#updateStationModal").find("#station-latitude").val().trim();
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
        urlWeb: urlWeb,
        user: user
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
}