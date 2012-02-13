<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");
  $server_group_id = $common->get_query_string($_GET, "server_group_id");

  $database->remove_server_group_from_server($server_id, $server_group_id);

  echo "Server group removal complete";

?>
