<?php

  include ("../common/include/ajax_header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");
  $name = $common->get_query_string($_GET, "name");
  $hostname = $common->get_query_string($_GET, "hostname");
  $os = $common->get_query_string($_GET, "os");
  $facility = $common->get_query_string($_GET, "facility");
  $service_tag = $common->get_query_string($_GET, "service_tag");
  $end_of_service_life = $common->get_query_string($_GET, "end_of_service_life");

  $database->update_server($server_id, $name, $hostname, $os, $facility, $service_tag, $end_of_service_life);

  echo "Server update complete";

?>
