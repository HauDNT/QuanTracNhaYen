<?php
function get_list_units()
{
  $result = db_fetch_array("SELECT * FROM units ORDER BY id DESC");
  return $result;
}

function get_list_units_by_name($name)
{
  $result = db_fetch_array("SELECT * FROM units WHERE name LIKE '%{$name}%' ORDER BY id DESC");
  return $result;
}


function get_unit_by_id($id)
{
  $result = db_fetch_row(("SELECT * FROM units WHERE id = '{$id}'"));
  return $result;
}

function update_unit($id, $data)
{
  return db_update('units', $data, "`id` = '{$id}'");
}
