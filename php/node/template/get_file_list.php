<?php

  require_once("../include/common.inc");
  require_once("../include/explorer.inc");

  $common = new common();
  $explorer = new explorer();

  $path = $common->get_query_string($_GET, 'path');

  $ret_array = array();

  if (is_array($path)) {
    foreach($path as $thispath) {
      $ret_array[$thispath] = array();
      $ret_array[$thispath] = $explorer->get_files($thispath);
    }
  } else {
    $ret_array[$path] = array();
    $ret_array[$path] = $explorer->get_files($path);
  }

  echo ('<?php $_FILES[\''.$common->get_hostname().'\'] = ');
  echo (var_export($ret_array)."; ?>\n");

?>
