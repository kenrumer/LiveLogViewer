<?php

  require_once("../include/common.inc");

  $common = new common();

  $path = $common->get_query_string($_GET, 'path');
  $limit = $common->get_query_string($_GET, 'limit');

  $file_size = filesize($path);

  if ($file_size > $limit) {
    $fh = @fopen ($path, "r");
    if ($fh !== FALSE) {
      fseek($fh, $file_size-$limit);
      echo (htmlentities(fread($fh, $limit)));
    }
    fclose($fh);
  } else {
    echo (htmlentities(file_get_contents($path)));
  }

?>
