<?php

  include ("../common/include/ajax_header.inc");

  $group_id = $common->get_query_string($_GET, "group_id");
  $users = $_GET["users"];

  $database->clear_users_for_group($group_id);

  $count = count($users);
  for ($i = 0; $i < $count; $i++) {
    $database->add_user_to_group($group_id, $users[$i]);
  }

  echo ("admin user list updated");

?>
