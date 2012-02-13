<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');
  $add_id = $common->get_query_string($_GET, 'add_id');

  $item_group_id = $database->add_item_to_item_group_by_id($type, $id, $add_id);

?>
