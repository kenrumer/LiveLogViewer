<?php

  require_once("../include/common.inc");

  $common = new common();

  $search_text = $common->get_query_string($_GET, 'search_text');
  $file = $common->get_query_string($_GET, 'file');

  $fh = @fopen($file, 'r');
  if ($fh !== FALSE) {
    while (!feof($fh)) {
      $line = fgets($fh);
      if (preg_match("/$search_text/i", $line)) {
        echo htmlentities ($line);
      }
    }
  }

?>
