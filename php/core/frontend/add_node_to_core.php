<?php

  @require_once("../common/include/backend_header.inc");
  @require_once("../common/include/common.inc");

  $common = new common();

  $type = $common->get_query_string($_GET, "type");
  switch ($type) {
    case "server":
      $fqdn = $common->get_query_string($_GET, "fqdn");
      $host_name = $common->get_query_string($_GET, "host_name");
      $ip_address = $common->get_query_string($_GET, "ip_address");
      $os = $common->get_query_string($_GET, "os");
      $database->add_server_to_core($host_name, $host_name, $fqdn, $ip_address, $os);
      $common->add_server_to_web_server($fqdn, $ip_address, "unix");
      break;
  }

?>
