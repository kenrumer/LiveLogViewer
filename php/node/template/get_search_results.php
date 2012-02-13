<?php

  require_once("../include/common.inc");
  require_once("../include/explorer.inc");

  $common = new common();
  $explorer = new explorer();

  $path = $common->get_query_string($_GET, 'path');
  $depth = $common->get_query_string($_GET, 'depth');
  $search_file_name = $common->get_query_string($_GET, 'search_file_name', FALSE);
  $search_text = $common->get_query_string($_GET, 'search_text', FALSE);
  $search_mtime = $common->get_query_string($_GET, 'search_date', FALSE);
  $search_date_low = $common->get_query_string($_GET, 'search_date_low', FALSE);
  $search_date_high = $common->get_query_string($_GET, 'search_date_high', FALSE);
  $search_size = $common->get_query_string($_GET, 'search_size', FALSE);
  $search_size_type = $common->get_query_string($_GET, 'search_size_type', FALSE);
  $search_size_value = $common->get_query_string($_GET, 'search_size_value', FALSE);

  set_time_limit(0);

  switch ($search_size) {
    case 0: {
      $size = 0;
      break;
    }
    case 1: {
      $size = 100;
      $search_size_type = 0;
      break;
    }
    case 2: {
      $size = 1024;
      $search_size_type = 0;
      break;
    }
    case 3: {
      $size = 1024;
      $search_size_type = 1;
      break;
    }
    case 4: {
      $size = $search_size_value;
      break;
    }
  }

  switch ($search_mtime) {
    case 0: {
      $search_date_low = 0;
      $search_date_high = 0;
      break;
    }
    case 1: {
      $search_date_low = 7;
      $search_date_high = 0;
      break;
    }
    case 2: {
      $search_date_low = 31;
      $search_date_high = 0;
      break;
    }
    case 3: {
      $search_date_low = 365;
      $search_date_high = 0;
      break;
    }
  }

  $files_array = $explorer->find_files($path, $depth, $search_file_name, $search_text, $search_date_low, $search_date_high, $size, $search_size_type);

  $ret_array = array();
  foreach($files_array as $file) {
    $ret_array[$path][$file['file_name']] = array();
    $ret_array[$path][$file['file_name']] = stat($file['file_name']);
    $ret_array[$path][$file['file_name']]['count'] = $file['count'];
  }

  echo ('<?php $_FILES[\''.$common->get_hostname().'\'] = ');
  echo (var_export($ret_array)."; ?>\n");

?>
