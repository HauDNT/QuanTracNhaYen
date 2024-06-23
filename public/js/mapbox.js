if ($('#map').length > 0) {

   // Thêm API Key Mapbox
   mapboxgl.accessToken =
      'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

   // Lấy giá trị tọa độ nếu sẵn có:
   var initialLongitude = $('#station-longtitude').val() || 105.14434709756426;
   var initialLatitude = $('#station-langtitude').val() || 9.914565453807697;

   // Khởi tạo Mapbox
   var map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [initialLongitude, initialLatitude], // Đặt vị trí mặc định
      zoom: 12,
   });

   $('.main-page').on('shown.bs.modal', '#addStationModal', function () {
      map.resize();
   });

   // Thêm thao tác thu phóng & xoay bản đồ
   map.addControl(new mapboxgl.NavigationControl());

   // Thêm điển đánh dấu trên bản đồ
   var marker = new mapboxgl.Marker().setLngLat([initialLongitude, initialLatitude]).addTo(map);

   // Add click event listener to the map
   map.on('click', function (e) {
      var coordinates = e.lngLat;
      alert('Kinh độ: ' + coordinates.lng + 'Vĩ độ: ' + coordinates.lat);

      // Gán giá trị tọa độ vào các ô input
      $('#station-longtitude').val(coordinates.lng)
      $('#station-langtitude').val(coordinates.lat)
      marker.setLngLat([coordinates.lng, coordinates.lat]);
   });
}