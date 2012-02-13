<?php

  @require_once("../common/include/backend_header.inc");
  @require_once("../common/include/common.inc");

  $common = new common();

  $application_id = $common->get_query_string($_GET, "application_id");
  $environment_id = $common->get_query_string($_GET, "environment_id");
  $build_id = $common->get_query_string($_GET, "build_id");

  $deployment_file_list = $database->get_deployment_file_list($application_id, $build_id, $environment_id);

  echo ('<?php $_DEPLOYMENT_FILE_LIST = ');
  echo (var_export($deployment_file_list)."; ?>\n");

?>
