<?php

  include ("../common/include/ajax_header.inc");

  $path_id = $common->get_query_string($_GET, "path_id");
  $name = $common->get_query_string($_GET, "name");
  $is_root = $common->get_query_string($_GET, "is_root");
  $is_directory = $common->get_query_string($_GET, "is_directory");

  $database->update_path($path_id, $name, $is_root, $is_directory);

  echo "Path update complete";

?>
