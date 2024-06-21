const handleAjaxRequest = (url) => {
    return new Promise((resolve, reject) => {
        // Sử dụng AJAX để lấy tọa độ các trạm từ main page:
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(error);
            },
        });
    });
};

// Hàm lấy tọa độ các trạm:
const getCoorAllStations = async () => {
    try {
        const response = await handleAjaxRequest('?mod=home&action=getCoorAllStations');
        return response;
    } catch (error) {
        alert('Đã xảy ra lỗi trong quá trình lấy tọa độ các trạm!');
    }
};

// Hàm lấy thông số đo của các tầng thuộc trạm:
const getPositionParamsStation = async (station_id) => {
    try {
        const response = await handleAjaxRequest(`?mod=home&action=getPosParams&station_id=${station_id}`);
        return response;
    } catch (error) {
        alert(`Đã xảy ra lỗi trong quá trình lấy thông tin các tầng của trạm ${station_id}!`);
    }
};

// Hàm gửi thông số đo của các tầng ra giao diện:
const applyPosParamsData = async (station_id) => {
    const data = await getPositionParamsStation(station_id);
    displayData(data);
};

const displayData = (data) => {
    // Lấy table trong trang Home:
    const tableBody = document.querySelector("#table-pos-station tbody");
    tableBody.innerHTML = '';    // Xóa đi dữ liệu cũ nếu có
    if (data.length > 0) {
        data.forEach(item => {
            const rowTable = document.createElement('tr');
            rowTable.classList.add('text-center');
    
            const positionDataCell = document.createElement('td');
            positionDataCell.textContent = `Tầng ${item.position}`;
    
            const tempDataCell = document.createElement('td');
            tempDataCell.textContent = item.avgTemp;
    
            const humidDataCell = document.createElement('td');
            humidDataCell.textContent = item.avgHumid;
    
            rowTable.appendChild(positionDataCell);
            rowTable.appendChild(tempDataCell);
            rowTable.appendChild(humidDataCell);
    
            tableBody.appendChild(rowTable);
        });
    }
    else {
        const rowTable = document.createElement('tr');
        rowTable.classList.add('text-center');

        const noDataCell = document.createElement('td');
        noDataCell.setAttribute('colspan', '3');
        noDataCell.textContent = 'Không có dữ liệu';

        rowTable.appendChild(noDataCell);
        tableBody.appendChild(rowTable);
    }
};

// Hàm khởi tạo bản đồ hiển thị toàn bộ trạm:
const mapShowAllStation = async (map) => {
    const coordinates = await getCoorAllStations();
    let currentPopup = null;

    coordinates.forEach((coordinate) => {
        // Tạo cửa sổ Popup cho từng Marker
        const popup = new mapboxgl
            .Popup({ closeOnClick: false })
            .setLngLat([
                +coordinate.longtitude,
                +coordinate.langtitude,
            ])
            .setHTML(`
                        <table class="table-popup">
                            <tbody>
                                <tr>
                                    <th>Tên trạm</th>
                                    <td class="text-center">${coordinate.name}</td>
                                </tr>
                                <tr>
                                    <th>Kinh độ</th>
                                    <td class="text-center">${coordinate.longtitude}</td>
                                </tr>
                                <tr>
                                    <th>Vĩ độ</th>
                                    <td class="text-center">${coordinate.langtitude}</td>
                                </tr>
                                <tr>
                                    <th>Nhiệt độ trung bình</th>
                                    <td class="text-center">${coordinate.avgTemp}</td>
                                </tr>
                                <tr>
                                    <th>Độ ẩm trung bình</th>
                                    <td class="text-center">${coordinate.avgHumid}</td>
                                </tr>
                                <tr>
                                    <th>Người quản lý</th>
                                    <td class="text-center">${coordinate.fullname}</td>
                                </tr>
                            </tbody>
                        </table>
                    `);

        // Tạo Marker
        const marker = new mapboxgl.Marker()
            .setLngLat([+coordinate.longtitude, +coordinate.langtitude])
            .addTo(map);

        // Thêm sự kiện click để hiển thị Popup
        marker.getElement().addEventListener('click', function () {
            if (currentPopup) {
                currentPopup.remove();
            }

            popup.addTo(map);

            // Lấy & gửi thông số của các tầng thuộc trạm tại Marker này:
            applyPosParamsData(coordinate.id);

            currentPopup = popup;
        });
    });
};

// Hàm khởi tạo bản đồ để chọn tọa độ trong Form và các sự kiện liên quan:
const mapForSelectCoor = (map, initialLongitude, initialLatitude) => {
    // Thêm marker
    var marker = new mapboxgl.Marker({
        draggable: true,
    })
        .setLngLat([initialLongitude, initialLatitude])
        .addTo(map);

    // Cập nhật tọa độ khi kéo marker
    function onDragEnd() {
        var lngLat = marker.getLngLat();
        document.getElementById('station-longtitude').value = lngLat.lng;
        document.getElementById('station-langtitude').value = lngLat.lat;
    }

    marker.on('dragend', onDragEnd);

    // Cập nhật tọa độ khi click vào bản đồ
    map.on('click', function (e) {
        var coords = e.lngLat;
        marker.setLngLat(coords);
        document.getElementById('station-longtitude').value = coords.lng;
        document.getElementById('station-langtitude').value = coords.lat;
        alert(`- Kinh độ: ${coords.lng} \n-Vĩ độ: ${coords.lat}`);
    });
};

document.addEventListener('DOMContentLoaded', function () {
    // Đặt tọa độ mặc định
    var initialLongitude = 105.14434709756426;
    var initialLatitude = 9.914565453807697;

    // Khởi tạo Mapbox
    mapboxgl.accessToken =
        'pk.eyJ1IjoidGllbmhhdTIwMDMiLCJhIjoiY2x3a200OG1uMDZiMDJpbng2anNtYWZldCJ9.NyOqze3rNjiaHZB7CLP-nw';

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [initialLongitude, initialLatitude],
        zoom: 12,
    });

    // Nếu có form add với update tọa độ trạm thì hiển thị bản đồ cho trạm:
    if (
        document.querySelector('#addStationModal') ||
        document.querySelector('#updateStationModal')
    ) {
        mapForSelectCoor(map, initialLongitude, initialLatitude);
    }

    // Nếu là trang chính thì show ra bản đồ chứa tọa độ tất cả trạm:
    else if (document.querySelector('#main-page')) {
        mapShowAllStation(map);
    }

    // Thêm thao tác thu phóng & xoay bản đồ
    map.addControl(new mapboxgl.NavigationControl());
});
