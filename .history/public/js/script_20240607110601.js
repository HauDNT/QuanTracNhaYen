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
    var idSensor = $('#id_sensor').val();
    var nameSensor = $('#name_sensor').val();
    var stationSensor = $('#station_sensor').val();
    var positionSensor = $('#position_sensor').val();
    if (idSensor.trim() == '' || nameSensor.trim() == '' || stationSensor == null || positionSensor.trim() == '') {
        showNotify("Vui lòng nhập đầy đủ thông tin.", "warning");
    } else {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                id_sensor: idSensor,
                name_sensor: nameSensor,
                station_sensor: station
            },

            success: function(response) {
                if(response == 'success') {
                    showNotify("Thêm mới thành công.", "success");
                }
            }
        });
    }
});