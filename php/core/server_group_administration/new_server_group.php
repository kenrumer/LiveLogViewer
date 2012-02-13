<?php

  include ("../common/include/ajax_header.inc");

  $name = $common->get_query_string($_GET, "name");
  $description = $common->get_query_string($_GET, "description");
  $parent_server_group_id = $common->get_query_string($_GET, "parent_server_group_id");

  $database->new_server_group($name, $description, $parent_server_group_id);

  echo "Server group add complete";

?>
