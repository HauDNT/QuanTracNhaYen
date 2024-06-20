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
            icon = '<i class="bi bi-exclamation-lg me-2"></i>';
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

if (sessionStorage.getItem('add-sensor')) {
    showNotify("Thêm mới thành công.", "success");
    sessionStorage.removeItem('add-sensor');
}

var mainPage = $('.main-page');

mainPage.on('keypress', '.search', function (e) {
    if (e.keyCode == 13) {
        $('.search-btn').click();
    }
});

mainPage.on('click', '.search-btn', function () {
    var searchQuery = $(this).prev('input').val();
    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: { search: searchQuery },
        success: function (data) {
            var value = $(data).find('.table').html();
            $('.table').html(value);
        },
        error: function () {
            showNotify("Lỗi hệ thống vui lòng thử lại sau.", "warning");
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
                    sessionStorage.setItem('add-sensor', 'success');
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

mainPage.on('click', '.update-modal', function (e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            console.log(response);
            $('#updateSensorModal').html(response);
            $('#updateSensorModal').modal('show');
        },

        error: function () {
            showNotify("Lỗi hệ thống vui lòng thử lại sau.", "danger");
        }
    });
});

mainPage.on('click', '#update_sensor', function (e) {
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
                    sessionStorage.setItem('update-sensor', 'success');
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