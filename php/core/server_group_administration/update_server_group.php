<?php

  include ("../common/include/ajax_header.inc");

  $server_group_id = $common->get_query_string($_GET, "server_group_id");
  $name = $common->get_query_string($_GET, "name");
  $description = $common->get_query_string($_GET, "description");
  $parent_server_group_id = $common->get_query_string($_GET, "parent_server_group_id");

  $database->update_server_group($server_group_id, $name, $description, $parent_server_group_id);

  echo "Server group update complete";

?>
