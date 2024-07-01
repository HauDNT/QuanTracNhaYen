if ($('#map').length > 0) {
  // Thêm API Key Mapbox
  mapboxgl.accessToken =
    'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

  // Khởi tạo Mapbox
  var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [105.14434709756426, 9.914565453807697],
    zoom: 12,
  });

  // Thêm thao tác thu phóng & xoay bản đồ
  map.addControl(new mapboxgl.NavigationControl());

  var markers = [];
  const popupOffsets = {
    'top': [0, 0],
    'bottom': [0, -35],
  }

  function displayTable(data, position, station) {
    var html =
      '<p class="fw-bold my-2">Tầng ' + position + '</p>' +
      '<table class="table table-hover table-borderless w-100 nowrap shadow-sm mb-1 rounded-3 overflow-hidden">' +
      '<thead>' +
      '<tr>' +
      '<th class="text-start">ĐVĐ</th>' +
      '<th class="text-center">Giá trị</th>' +
      '<th class="text-center">Ký hiệu</th>' +
      '</tr>' +
      '</thead>' +
      '<tbody>';
    data.forEach(element => {
      if (element["station_id"] == station["id"]) {
        html +=
          '<tr>' +
          '<td class="text-start">' + element['name'] + '</td>' +
          '<td class="text-center">' + element['value'] + '</td>' +
          '<td class="text-center">' + element['symbol'] + '</td>' +
          '</tr>';
      }
    });
    html += '</tbody></table>';
    return html;
  }

  function displayData(data, position_list, station) {
    var html =
      '<p class="popup-title fw-bold text-primary border-1 border-bottom border-light-subtle w-100 m-0 py-2">' + station["name"] + '</p>' +
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
    markers.forEach(function (markerObj) {
      markerObj.marker.remove();
      markerObj.popup.remove();
    });
    markers = [];

    data.station.forEach(element => {
      var marker = new mapboxgl.Marker()
        .setLngLat([element["longtitude"], element["langtitude"]])
        .addTo(map);

      var popup = new mapboxgl.Popup({ closeOnClick: false, closeButton: false, offset: popupOffsets })
        .setLngLat([element["longtitude"], element["langtitude"]])
        .setHTML(displayData(data.sensor_value, data.position_list, element))
        .addTo(map);

      markers.push({ marker: marker, popup: popup });
    })
  }

  function test() {
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

  test();
  // setInterval(() => {
  //   test();
  // }, 1000);

  // map.on('click', function (e) {
  //   var coordinates = e.lngLat;
  //   $('#station-longtitude').val(coordinates.lng)
  //   $('#station-langtitude').val(coordinates.lat)
  //   new mapboxgl.Marker().setLngLat([coordinates.lng, coordinates.lat]).addTo(map);
  // });
}