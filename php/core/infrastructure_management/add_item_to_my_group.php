<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');

  switch ($type) {
    case "server_group":
      $database->add_item_group_to_item_group_by_id("server", $database->get_my_item_group_id("server", $session->get("user_name")), $id);
      break;
    case "application_group":
      $database->add_item_group_to_item_group_by_id("application", $database->get_my_item_group_id("application", $session->get("user_name")), $id);
      break;
    case "database_group":
      $database->add_item_group_to_item_group_by_id("database", $database->get_my_item_group_id("database", $session->get("user_name")), $id);
      break;
    case "network_group":
      $database->add_item_group_to_item_group_by_id("network", $database->get_my_item_group_id("network", $session->get("user_name")), $id);
      break;
  }

?>
