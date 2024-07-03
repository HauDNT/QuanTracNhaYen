<?php
function get_list_indicators()
{
  $result = db_fetch_array("SELECT * FROM indicators ORDER BY id DESC");
  return $result;
}

function get_list_indicators_by_name($name)
{
  $result = db_fetch_array("SELECT * FROM indicators WHERE name LIKE '%{$name}%' ORDER BY id DESC");
  return $result;
}


function get_indicator_by_id($id)
{
  $result = db_fetch_row(("SELECT * FROM indicators WHERE id = '{$id}'"));
  return $result;
}

function update_indicator($id, $data)
{
  return db_update('indicators', $data, "`id` = '{$id}'");
}
