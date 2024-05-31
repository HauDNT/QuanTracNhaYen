$(document).ready(function () {
    $(document).on('click', '.add-sensor', function() {
        const button = $(this);
        const sensorId = $(this).data('sensor-id');
        const stationId = $(this).data('station-id');

        $.ajax({
            url: '?mod=stations&action=addSensorToStation',
            type: 'POST',
            data: {
                sensorId: sensorId,
                stationId: stationId,
            },
            success: function (res) {
                button.removeClass('btn-primary add-sensor').addClass('btn-danger remove-sensor').text('Xóa');
                alert(res);
            },
            error: function () {
                alert('Đã xảy ra lỗi khi thêm cảm biến vào trạm!');
            },
        });
    });

    $(document).on('click', '.remove-sensor', function() {
        const button = $(this);
        const sensorId = $(this).data('sensor-id');
        const stationId = $(this).data('station-id');

        $.ajax({
            url: '?mod=stations&action=deleteSensorFromStation',
            type: 'POST',
            data: {
                sensorId: sensorId,
                stationId: stationId,
            },
            success: function (res) {
                button.removeClass('btn-danger remove-sensor').addClass('btn-primary add-sensor').text('Thêm');
                alert(res);
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    });
});
