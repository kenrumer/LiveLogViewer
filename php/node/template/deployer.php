<?php

  require_once("../include/common.inc");
  require_once("../include/explorer.inc");

  $common = new common();

  $application_id = $common->get_query_string($_GET, "application_id");
  $environment_id = $common->get_query_string($_GET, "environment_id");
  $build_id = $common->get_query_string($_GET, "build_id");

  $path = getcwd();
  $frontend_server = $_SERVER['SERVER_NAME'];
  $hostname = $common->get_hostname();
  $path_parts = split('[\\\/]', $path);
  array_pop($path_parts);
  $parent = implode('/', $path_parts);

  //Get deployment file manifest
  require ("https://".$frontend_server."/frontend/get_deployment_file_list.php?application_id=".$application_id."&environment_id=".$environment_id."&build_id=".$build_id);

  if (!isset($_DEPLOYMENT_FILE_LIST)) {
    exit(1);
  }

  $temp_path = $common->make_temp_dir();

  $configs = array();
  //Get config file(s)
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "9") {
      $configs[] = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
    }
  }

  function ini_merge ($config_ini, $custom_ini) {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    foreach ($custom_ini AS $k => $v) {
      if (is_array($v)) {
        $config_ini[$k] = ini_merge($config_ini[$k], $custom_ini[$k]);
      } else {
        $config_ini[$k] = $v;
      }
    }
    return $config_ini;
  }

  $config = array();
  foreach ($configs as $config_file) {
    $config = ini_merge($config, parse_ini_file($config_file, true));
  }

  var_export($config);

  chdir($temp_path);
  $fh = fopen($temp_path."/config.ini", "w");
  foreach ($config as $section_key => $section_value) {
    if (is_array($section_value)) {
      fwrite($fh, "[".$section_key."]\n");
      foreach ($section_value as $key => $value) {
        if (is_array($value)) {
          foreach ($value as $array_value) {
            fwrite($fh, $key."[]=".$array_value."\n");
          }
        } else {
          fwrite($fh, $key."=".$value."\n");
        }
      }
    } else {
      fwrite($fh, $section_key."=".$section_value."\n");
    }
  }
  fclose($fh);

  exit(0);

  //Get checkinstall file
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "4") {
      $checkinstall = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
      if ($_DEPLOYMENT_FILE_LIST['function'] && $_DEPLOYMENT_FILE_LIST[$i]['file_name']) {
        if ($_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']) {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']." ".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        } else {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        }
      }
    }
  }

  //Get preinstall file
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "1") {
      $preinstall = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
      if ($_DEPLOYMENT_FILE_LIST['function'] && $_DEPLOYMENT_FILE_LIST[$i]['file_name']) {
        if ($_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']) {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']." ".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        } else {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        }
      }
    }
  }
  echo $preinstall;
  echo (htmlentities(file_get_contents($preinstall)));
  //Clean-up
  $dh = opendir($temp_path);
  while (FALSE !== ($file = readdir($dh))) {
    if ($file == '.' || $file == '..') continue;
    unlink($temp_path."/".$file);
  }
  closedir($dh);
  rmdir($temp_path);
  exit(0);

  $archives = array();
  //Get archive file(s)
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "10") {
      $archives[] = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
    }
  }

  //Get install file
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "2") {
      $install = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
      if ($_DEPLOYMENT_FILE_LIST['function'] && $_DEPLOYMENT_FILE_LIST[$i]['file_name']) {
        if ($_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']) {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']." ".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        } else {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        }
      }
    }
  }

  //Get postinstall file
  for ($i = 0; $i < count($_DEPLOYMENT_FILE_LIST); $i++) {
    if ($_DEPLOYMENT_FILE_LIST[$i]['file_type_idfile_type'] == "3") {
      $postinstall = $common->get_url_contents("https://".$frontend_server."/frontend/get_deployment_file.php?file_system_table=".$_DEPLOYMENT_FILE_LIST[$i]['table_name']."&file_id=".$_DEPLOYMENT_FILE_LIST[$i]['idfile']."&file_name=".$_DEPLOYMENT_FILE_LIST[$i]['file_name'], $temp_path, $_DEPLOYMENT_FILE_LIST[$i]['file_name']);
      if ($_DEPLOYMENT_FILE_LIST['function'] && $_DEPLOYMENT_FILE_LIST[$i]['file_name']) {
        if ($_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']) {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_EXECUTION_CONTROL['prefix_path']." ".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        } else {
          eval($_DEPLOYMENT_FILE_LIST['function']."(\'".$_DEPLOYMENT_FILE_LIST[$i]['file_name']."\')");
        }
      }
    }
  }

?>
