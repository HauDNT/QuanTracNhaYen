<?php
function get_list_units()
{
   $result = db_fetch_array("SELECT * FROM units");
   return $result;
}

function get_unit_by_id($id)
{
   $result = db_fetch_row(("SELECT * FROM units WHERE id = '{$id}'"));
   return $result;
}

function update_unit($id, $data)
{
   db_update('units', $data, "`id` = '{$id}'");
}
