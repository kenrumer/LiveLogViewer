<?php

  include ("../common/include/ajax_header.inc");

  $name = $common->get_query_string($_GET, "name");
  $hostname = $common->get_query_string($_GET, "hostname");
  $fqdn = $common->get_query_string($_GET, "fqdn");
  $primary_ip = $common->get_query_string($_GET, "primary_ip");
  $os = $common->get_query_string($_GET, "os", FALSE);
  $facility = $common->get_query_string($_GET, "facility", FALSE);
  $service_tag = $common->get_query_string($_GET, "service_tag", FALSE);
  $end_of_service_life = $common->get_query_string($_GET, "end_of_service_life", FALSE);
  $os_type = $common->get_query_string($_GET, "os_type");

  $database->new_server($name, $hostname, $fqdn, $primary_ip, $os, $facility, $service_tag, $end_of_service_life);

  $common->add_server_to_web_server($fqdn, $primary_ip, $os_type);
  $common->restart_web_server();

  echo "Server add complete";

?>
