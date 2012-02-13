<?php

  require_once("../include/common.inc");

  $common = new common();

  $path = $common->get_query_string($_GET, 'path');
  $file_pos = $common->get_query_string($_GET, 'file_pos');

  echo('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");
  echo('<response>');
  echo('<file_pos>'.filesize($path).'</file_pos>');
  echo('  <file_text>');
  $fp = fopen($path, 'r');
  fseek($fp, $file_pos);
  $str = fread($fp, 1024);
  while ($str != "") {
    echo (htmlentities($str));
    $str = fread($fp, 4096);
  }
  echo('  </file_text>');
  echo('</response>');
?>
