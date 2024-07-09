<?php

function get_station()
{
  $result = db_fetch_array("SELECT * FROM stations");
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
    COALESCE(AVG(sv.value), 0) AS average_value
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
