<?php

  include ("../common/include/ajax_header.inc");

  $name = $common->get_query_string($_GET, "name");
  $is_root = $common->get_query_string($_GET, "is_root");
  $is_directory = $common->get_query_string($_GET, "is_directory");

  $database->new_path($name, $is_root, $is_directory);

  echo "Path add complete";

?>
