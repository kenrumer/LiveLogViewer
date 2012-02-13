<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");

  $database->remove_item("server", $server_id);

?>
