<?php

function construct()
{
  //    echo "DÙng chung, load đầu tiên";
  load_model('index');
}

function indexAction()
{
  $list_users = get_list_users();
  if (isset($_POST["search"])) {
    $list_users = get_list_users_by_search($_POST["search"], $_POST["userRole"], $_POST["userStatus"]);
  }

  $data_list = array();
  foreach ($list_users as $index => $value) {
    $data_list[] = array(
      'no' => $index + 1,
      'id' => $value['id'],
      'avatar' => $value['avatar'],
      'fullname' => $value['fullname'],
      'email' => $value['email'],
      'role' => $value['name'],
      'date_created' => date('d-m-Y', strtotime($value['date_created'])),
      'status' => $value['status']
    );
  }

  $item_per_page = 10;
  $current_page = 1;
  if (isset($_POST["page"])) {
    $current_page = $_POST["page"];
  }
  $total_page = ceil(count($data_list) / $item_per_page);
  $offset = ($current_page - 1) * $item_per_page;

  $currentItems = array_slice($data_list, $offset, $item_per_page);

  $data = array(
    'active' => 'information',
    'list_users' => $currentItems,
    'list_roles' => get_role_users(),
    'total_page' => $total_page,
    'current_page' => $current_page,
  );
  load_view('index', $data);
}
