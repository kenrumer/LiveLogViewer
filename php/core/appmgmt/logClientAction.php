<?php

  include ("../../docroot/common/include/backend_header.inc");

  $wo_id = $_GET['wo_id'];
  $action = $_GET['action'];
  $message = $_GET['message'];

  if ( $action == "LOG" ) {
    $database->kb_wo_log_update($wo_id,$message);
  }
  if ( $action == "STATUS" ) {
    $database->kb_wo_status_update($wo_id,$message);
  }

?>
