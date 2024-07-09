<?php

function get_position() {
  $result = db_fetch_array("SELECT position FROM sensors GROUP BY position");
  return $result;
}
function get_indicator()
{
  $result = db_fetch_array("SELECT * FROM indicators");
  return $result;
}

function get_label_month()
{
  $result = db_fetch_array("SELECT 
  m.month_number AS month,
  i.name AS indicator_name
FROM (
  SELECT 1 AS month_number UNION ALL
  SELECT 2 UNION ALL
  SELECT 3 UNION ALL
  SELECT 4 UNION ALL
  SELECT 5 UNION ALL
  SELECT 6 UNION ALL
  SELECT 7 UNION ALL
  SELECT 8 UNION ALL
  SELECT 9 UNION ALL
  SELECT 10 UNION ALL
  SELECT 11 UNION ALL
  SELECT 12
) AS m
CROSS JOIN indicators AS i
LEFT JOIN sensor_values AS sv ON MONTH(sv.createdAt) = m.month_number AND sv.indicator_id = i.id
WHERE i.unit != 'safety'
GROUP BY m.month_number
ORDER BY m.month_number");
  return $result;
}

function get_data_month()
{
  $result = db_fetch_array("SELECT 
    m.month_number AS month,
    i.name AS indicator_name,
    AVG(sv.value) AS average_value
FROM (
    SELECT 1 AS month_number UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7 UNION ALL
    SELECT 8 UNION ALL
    SELECT 9 UNION ALL
    SELECT 10 UNION ALL
    SELECT 11 UNION ALL
    SELECT 12
) AS m
CROSS JOIN indicators AS i
LEFT JOIN sensor_values AS sv ON MONTH(sv.createdAt) = m.month_number AND sv.indicator_id = i.id
WHERE i.unit != 'safety'
GROUP BY m.month_number, i.name
ORDER BY m.month_number, i.name");
  return $result;
}

function get_data_table() {
  $result = db_fetch_array("SELECT i.name AS indicator, sv.value, i.unit, st.name AS station, ss.position, sv.createdAt FROM stations st JOIN sensors ss ON st.id = ss.station_id JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON i.id = sv.indicator_id ORDER BY st.id, ss.position");
  return $result;
}

function get_data_table_by_search($search) {
  $result = db_fetch_array("SELECT i.name AS indicator, sv.value, i.unit, st.name AS station, ss.position, sv.createdAt FROM stations st JOIN sensors ss ON st.id = ss.station_id JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON i.id = sv.indicator_id WHERE st.name LIKE '%{$search}%' ORDER BY st.id, ss.position");
  return $result;
}