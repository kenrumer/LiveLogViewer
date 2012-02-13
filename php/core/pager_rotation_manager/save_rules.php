<?php

  include ("../common/include/ajax_header.inc");

  $group_id = $common->get_query_string($_GET, "group_id");
  $rules = $_GET["rules"];

  $database->clear_schedule_for_group($group_id);

  $count = count($rules);
  for ($i = 0; $i < $count; $i++) {
    $schedule = explode(" | ", $rules[$i]);
    $database->add_schedule_to_group($group_id, $schedule[0], $schedule[1], $schedule[2]);
  }

  echo ("schedule updated");

?>
