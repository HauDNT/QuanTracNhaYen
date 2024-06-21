<?php

function get_list_users()
{
    $result = db_fetch_array("SELECT * FROM `tbl_users`");
    return $result;
}

function get_user_by_id($id)
{
    $item = db_fetch_row("SELECT * FROM `tbl_users` WHERE `user_id` = {$id}");
    return $item;
}

function get_stations_avg_params()
{
    $result = db_fetch_array ("
        SELECT 
            st.id,
            st.name,
            st.longtitude, 
            st.langtitude,
            us.fullname, 
            ROUND(AVG(CASE WHEN u.name = 'Nhiệt độ' THEN sv.value ELSE NULL END), 3) AS `avgTemp`,
            ROUND(AVG(CASE WHEN u.name = 'Độ ẩm' THEN sv.value ELSE NULL END), 3) AS `avgHumid`
        FROM sensor_values sv
        RIGHT JOIN sensors s ON s.id = sv.sensor_id 
        RIGHT JOIN units u ON u.id = sv.unit_id 
        RIGHT JOIN stations st ON st.id = s.station_id
        JOIN userinfo us ON us.account_id = st.user_id
        WHERE DATE(sv.createdAt) = CURRENT_DATE OR sv.createdAt IS NULL
        GROUP BY st.name, us.fullname;
    ");

    return $result;
}

function get_position_params($station_id)
{
    $result = db_fetch_array ("
        SELECT 
            st.id,
            st.name,
            s.position,
            us.fullname, 
            ROUND(AVG(CASE WHEN u.name = 'Nhiệt độ' THEN sv.value ELSE NULL END), 3) AS `avgTemp`,
            ROUND(AVG(CASE WHEN u.name = 'Độ ẩm' THEN sv.value ELSE NULL END), 3) AS `avgHumid`
        FROM sensor_values sv
        JOIN sensors s ON s.id = sv.sensor_id 
        JOIN units u ON u.id = sv.unit_id 
        JOIN stations st ON st.id = s.station_id
        JOIN userinfo us ON us.account_id = st.user_id
        WHERE DATE(sv.createdAt) = CURRENT_DATE AND st.id = {$station_id}
        GROUP BY st.id, st.name, s.position, us.fullname;
    ");

    return $result;
}