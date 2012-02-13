<?php

  include ("../../docroot/common/include/backend_header.inc");

  $wo_id = $_POST['wo_id'];
  $action = $_POST['action'];
  $message = $_POST['message']

  function results_action($ra_wo_id,$ra_action,$ra_message) {

    global $database;

    list($ra_action , $ra_data) = split(":" , $ra_results , 2);
    $ra_data = chop($ra_data);
    if ( $ra_action == "LOG" ) {
      $database->kb_wo_log_update($ra_wo_id,$ra_data);
    }
    if ( $ra_action == "STATUS" ) {
      $database->kb_wo_status_update($ra_wo_id,$ra_data);
    }
    return 1;

  }

