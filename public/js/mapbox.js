// Thêm API Key Mapbox
mapboxgl.accessToken =
    'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

// Lấy giá trị tọa độ nếu sẵn có:
var initialLongitude = document.getElementById('station-longtitude').value || 105.14434709756426;
var initialLatitude = document.getElementById('station-langtitude').value || 9.914565453807697;

// Khởi tạo Mapbox
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [initialLongitude, initialLatitude], // Đặt vị trí mặc định
    zoom: 12,
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
    document.getElementById('station-longtitude').value = coordinates.lng;
    document.getElementById('station-langtitude').value = coordinates.lat;
});
