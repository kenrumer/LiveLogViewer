<?php

  require_once ("../common/include/common.inc");
  require_once ("../common/include/session.inc");
  require_once ("../common/include/database.inc");
  require_once ("../common/include/access.inc");

  $script_name = $_SERVER['SCRIPT_NAME'];
  $hostname = substr($script_name, 1, strpos($script_name, "/", 1) - 1);
  $frontend_server = $_SERVER['SERVER_NAME'];

  $common = new common();

  $user_name = $common->get_post_string($_POST, "user_name", FALSE);
  $password = $common->get_post_string($_POST, "password", FALSE);

  $session = new session();
  $session->read_config();

  $database = new database($session);
  if (!$database->is_valid_user($user_name)) {
    header('HTTP/1.1 403 Forbidden');
    echo ("{ success: false, errors: {reason: 'Invalid user name'}}");
    exit(0);
  }

  $access = new access($session);
  $access->login($user_name, $password);

?>

