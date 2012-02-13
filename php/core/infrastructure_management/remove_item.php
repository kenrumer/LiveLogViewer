<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');

  switch ($type) {
    case "my_server_root_group":
    case "server_group":
    case "server_root_group":
      $database->remove_item_group_from_item_group("server", $id);
      break;
    case "my_application_root_group":
    case "application_group":
    case "application_root_group":
      $database->remove_item_group_from_item_group("application", $id);
      break;
    case "my_database_root_group":
    case "database_group":
    case "database_root_group":
      $database->remove_item_group_from_item_group("database", $id);
      break;
    case "my_network_root_group":
    case "network_group":
    case "network_root_group":
      $database->remove_item_group_from_item_group("network", $id);
      break;
  }

?>
