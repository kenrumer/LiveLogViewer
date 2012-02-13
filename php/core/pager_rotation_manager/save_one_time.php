<?php

  include ("../common/include/ajax_header.inc");

  $group_id = $common->get_query_string($_GET, "group_id");
  $member_id = $common->get_query_string($_GET, "member_id");

  $database->set_current_user_for_group($group_id, $member_id);

  echo ("one-time user now on-call");

?>
