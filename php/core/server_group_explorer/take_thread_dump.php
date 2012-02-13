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

  $server_id = $common->get_query_string($_GET, "server_id");

  set_time_limit(0);

  header('Content-Description: File Transfer');
  header('Pragma: public');
  header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private', false);
  header('Content-Type: application/force-download');
  header('Content-Transfer-Encoding: binary');

  $id = $common->get_query_string($_GET, 'server_id');

  header('Content-Disposition: attachment; filename=threaddump.zip');

  $database = new database($session);

  $server = $database->get_server($server_id);

  if (isset($_SERVER['HTTPS'])) {
    @require ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_thread_dump.php");
  } else {
    @require ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_thread_dump.php");
  }

?>
