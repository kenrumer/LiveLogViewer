<?php

  @require_once ("../common/include/common.inc");
  @require_once ("../common/include/database.inc");
  @require_once ("../common/include/session.inc");
  @require_once ("../common/include/access.inc");

  $script_name = $_SERVER['SCRIPT_NAME'];
  $hostname = substr($script_name, 1, strpos($script_name, "/", 1) - 1);
  $frontend_server = $_SERVER['SERVER_NAME'];

  $common = new common();
  $session = new session();
  $access = new access($session);

  if (!$access->is_logged_in()) {
    $common->print_header();
    $session->read_config();
    $access->print_login_page();
    exit(0);
  }

  header("Content-Type: text/xml");

  $database = new database($session);

  $server_id = $common->get_query_string($_GET, "server_id");
  $server = $database->get_server($server_id);
  $path = $common->get_query_string($_GET, "path");
  $file_pos = $common->get_query_string($_GET, "file_pos");

  if (isset($_SERVER['HTTPS'])) {
    readfile ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/tail_file.php?path=".urlencode($path)."&file_pos=".$file_pos);
  } else {
    readfile ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/tail_file.php?path=".urlencode($path)."&file_pos=".$file_pos);
  }

?>
