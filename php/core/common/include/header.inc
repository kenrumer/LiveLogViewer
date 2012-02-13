<?php

  require_once ("../common/include/common.inc");
  require_once ("../common/include/database.inc");
  require_once ("../common/include/session.inc");
  require_once ("../common/include/access.inc");

  $script_name = $_SERVER['SCRIPT_NAME'];
  $hostname = substr($script_name, 1, strpos($script_name, "/", 1) - 1);
  $frontend_server = $_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'];

  $common = new common();
  $session = new session();
  $access = new access($session);

  $common->print_header();
  if (!$access->is_logged_in()) {
    $session->read_config();
    $access->print_login_page();
  }

  $database = new database($session);
  //$group = $database->get_group_for_user($session->get("user_name"));
  //$session->set("group_id", "none", $database->get_group_for_user($session->get("user_name"));

?>

