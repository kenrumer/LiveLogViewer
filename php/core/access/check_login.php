<?php

  require_once ("../common/include/ajax_header.inc");

  $session_id = session_id();

  if ($access->is_logged_in()) {
    header('HTTP/1.1 200 OK');
  } else {
    header('HTTP/1.1 403 Forbidden');
  }

?>
