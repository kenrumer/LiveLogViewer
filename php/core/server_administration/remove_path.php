<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");
  $path_id = $common->get_query_string($_GET, "path_id");

  $database->remove_path_from_server($server_id, $path_id);

  echo "Server path removal complete";

?>
