<?php

function get_position()
{
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
  m.month_number AS month
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

function get_label_week()
{
  $result = db_fetch_array("SELECT 
    d.weekdays
FROM (
    SELECT 1 AS weekdays UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7
) AS d
CROSS JOIN indicators AS i
LEFT JOIN sensor_values AS sv 
    ON WEEKDAY(sv.createdAt) + 1 = d.weekdays 
    AND sv.indicator_id = i.id
    AND sv.createdAt >= DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY)
    AND sv.createdAt < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 7 DAY)
WHERE i.unit != 'safety'
GROUP BY d.weekdays
ORDER BY d.weekdays;
");
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

function get_data_week()
{
  $result = db_fetch_array("SELECT 
    d.weekdays,
    i.name AS indicator_name,
    AVG(sv.value) AS average_value
    FROM (
        SELECT 1 AS weekdays UNION ALL
        SELECT 2 UNION ALL
        SELECT 3 UNION ALL
        SELECT 4 UNION ALL
        SELECT 5 UNION ALL
        SELECT 6 UNION ALL
        SELECT 7
    ) AS d
    CROSS JOIN indicators AS i
    LEFT JOIN sensor_values AS sv 
        ON WEEKDAY(sv.createdAt) + 1 = d.weekdays 
        AND sv.indicator_id = i.id
        AND sv.createdAt >= DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY)
        AND sv.createdAt < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE())) DAY), INTERVAL 7 DAY)
    WHERE i.unit != 'safety'
    GROUP BY d.weekdays, i.name
    ORDER BY d.weekdays, i.name
    ");
  return $result;
}

function get_data_last_week()
{
  $result = db_fetch_array("SELECT 
    d.weekdays,
    i.name AS indicator_name,
    AVG(sv.value) AS average_value
FROM (
    SELECT 1 AS weekdays UNION ALL
    SELECT 2 UNION ALL
    SELECT 3 UNION ALL
    SELECT 4 UNION ALL
    SELECT 5 UNION ALL
    SELECT 6 UNION ALL
    SELECT 7
) AS d
CROSS JOIN indicators AS i
LEFT JOIN sensor_values AS sv 
    ON WEEKDAY(sv.createdAt) + 1 = d.weekdays 
    AND sv.indicator_id = i.id
    AND sv.createdAt >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE()) + 1) DAY), INTERVAL 7 DAY)
    AND sv.createdAt < DATE_SUB(CURDATE(), INTERVAL (WEEKDAY(CURDATE()) + 1) DAY)
WHERE i.unit != 'safety'
GROUP BY d.weekdays, i.name
ORDER BY d.weekdays, i.name;
");
  return $result;
}

function get_data_table()
{
  $result = db_fetch_array("SELECT i.name AS indicator, sv.value, i.unit, st.name AS station, ss.position, sv.createdAt FROM stations st JOIN sensors ss ON st.id = ss.station_id JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON i.id = sv.indicator_id ORDER BY sv.createdAt DESC, st.id, ss.position");
  return $result;
}

function get_data_table_by_search($search, $position, $indicator, $dateStart, $dateEnd)
{
  $sql = "SELECT i.name AS indicator, sv.value, i.unit, st.name AS station, ss.position, sv.createdAt FROM stations st JOIN sensors ss ON st.id = ss.station_id JOIN sensor_values sv ON ss.id = sv.sensor_id JOIN indicators i ON i.id = sv.indicator_id WHERE st.name LIKE '%{$search}%'";
  if ($position != '-1') {
    $sql .= " AND ss.position = {$position}";
  }

  if ($indicator != "-1") {
    $sql .= " AND i.id = '{$indicator}'";
  }

  if (!empty($dateStart) && empty($dateEnd)) {
    $dateStart = date('Y-m-d', strtotime($dateStart));
    $sql .= " AND DATE(sv.createdAt) = '{$dateStart}'";
  } else if (empty($dateStart) && !empty($dateEnd)) {
    $dateEnd = date('Y-m-d', strtotime($dateEnd));
    $sql .= " AND DATE(sv.createdAt) = '{$dateEnd}'";
  } else if (!empty($dateStart) && !empty($dateEnd)) {
    $dateStart = date('Y-m-d', strtotime($dateStart));
    $dateEnd = date('Y-m-d', strtotime($dateEnd));
    $sql .= " AND DATE(sv.createdAt) BETWEEN '{$dateStart}' AND '{$dateEnd}'";
  }

  $sql .= " ORDER BY sv.createdAt DESC, st.id, ss.position";

  $result = db_fetch_array($sql);
  return $result;
}
