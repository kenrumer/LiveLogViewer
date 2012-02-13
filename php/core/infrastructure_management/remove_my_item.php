<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');
  $parent_id = $common->get_query_string($_GET, 'parent_id');

  switch ($type) {
    case "my_server_group":
      $database->remove_item_group_from_my_item_group("server", $parent_id, $id);
      break;
    case "my_application_group":
      $database->remove_item_group_from_my_item_group("application", $parent_id, $id);
      break;
    case "my_database_group":
      $database->remove_item_group_from_my_item_group("database", $parent_id, $id);
      break;
    case "my_network_group":
      $database->remove_item_group_from_my_item_group("network", $parent_id, $id);
      break;
  }

?>
