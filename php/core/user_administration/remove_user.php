<?php

  include ("../common/include/ajax_header.inc");

  $user_name = $common->get_query_string($_GET, "user_name");

  $database->remove_user($user_name);

?>
