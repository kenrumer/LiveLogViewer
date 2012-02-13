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

  $path = $common->get_query_string($_GET, "path");
  $server_id = $common->get_query_string($_GET, "server_id");

  set_time_limit(0);

  header('Content-Description: File Transfer');
  header('Pragma: public');
  header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private', false);
  header('Content-Type: application/force-download');
  header('Content-Transfer-Encoding: binary');

  if (strpos($path, "/") === FALSE) {
    $basename = substr($path, strrpos($path, "\\")+1);
    if ($basename == "") {
      $dirname = substr($path, 0, strrpos($path, "\\"));
      $basename = substr($dirname, strrpos($dirname, "\\")+1);
    }
  } else {
    $basename = basename($path);
  }

  header('Content-Disposition: attachment; filename='.str_replace(" ", "_", $basename).'.zip');

  $database = new database($session);

  $server = $database->get_server($server_id);

  if (isset($_SERVER['HTTPS'])) {
    include("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_zip_item.php?path=".urlencode($path));
  } else {
    include("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_zip_item.php?path=".urlencode($path));
  }

?>
