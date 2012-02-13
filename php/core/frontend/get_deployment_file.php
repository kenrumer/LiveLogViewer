<?php

  @require_once("../common/include/backend_header.inc");
  @require_once("../common/include/common.inc");

  $common = new common();

  //$file_system_table = "local_file_system";
  //$file_id = 1;
  $file_system_table = $common->get_query_string($_GET, "file_system_table");
  $file_id = $common->get_query_string($_GET, "file_id");
  $file_name = $common->get_query_string($_GET, "file_name");

  //$deployment_file_system_info[0]['path'] = "/app/asc/repository/07-01-2009";

  $deployment_file_system_info = $database->get_deployment_file_system_info($file_system_table, $file_id);

  switch ($file_system_table) {
    case "local_file_system":
      $path = $deployment_file_system_info[0]['path']."/".$file_name;
      echo (htmlentities(file_get_contents($path)));
      break;
  }

  exit(0);

?>
