<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");
  $server_group_id = $common->get_query_string($_GET, "server_group_id");

  $database->add_server_group_to_server($server_id, $server_group_id);

  echo "Server group update complete";

?>
