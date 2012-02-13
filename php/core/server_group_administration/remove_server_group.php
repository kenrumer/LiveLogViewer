<?php

  include ("../common/include/ajax_header.inc");

  $server_group_id = $common->get_query_string($_GET, "server_group_id");

  $database->remove_item("server_group", $server_group_id);

?>
