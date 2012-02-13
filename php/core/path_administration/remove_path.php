<?php

  include ("../common/include/ajax_header.inc");

  $path_id = $common->get_query_string($_GET, "path_id");

  $database->remove_path($path_id);

?>
