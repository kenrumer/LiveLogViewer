<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, 'server_id');
  $add_id = $common->get_query_string($_GET, 'add_id');

  $item_group_id = $database->add_allowed_path_to_server_by_id($server_id, $add_id);

?>
