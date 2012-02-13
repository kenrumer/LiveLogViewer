<?php

  require_once("../include/common.inc");
  require_once("../include/explorer.inc");

  $common = new common();
  $explorer = new explorer();

  $ret_array = array();

  $paths = split(",", $common->get_query_string($_GET, 'paths'));

  foreach($paths as $path) {
    $ret_array[$path] = $explorer->get_directory_contents($path);
  }
  echo ('<?php $_DIR_CONTENT[\''.$common->get_hostname().'\'] = ');
  echo (var_export($ret_array)."; ?>\n");

?>
