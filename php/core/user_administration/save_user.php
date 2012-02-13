<?php

  include ("../common/include/ajax_header.inc");

  $user_name = $common->get_query_string($_GET, "user_name");
  $display_name = $common->get_query_string($_GET, "display_name");
  $first_name = $common->get_query_string($_GET, "first_name");
  $last_name = $common->get_query_string($_GET, "last_name");
  $office = $common->get_query_string($_GET, "office");
  $department = $common->get_query_string($_GET, "department");
  $title = $common->get_query_string($_GET, "title");
  $manager = $common->get_query_string($_GET, "manager");
  $email_address = $common->get_query_string($_GET, "email_address");
  $sms_number = $common->get_query_string($_GET, "sms_number");
  $phone_number = $common->get_query_string($_GET, "phone_number");
  $cell_phone_number = $common->get_query_string($_GET, "cell_phone_number");
  $group_id = $common->get_query_string($_GET, "group_id");

  $database->save_user($user_name, $display_name, $first_name, $last_name, $office, $department, $title, $manager, $email_address, $sms_number, $phone_number, $cell_phone_number, $group_id);

?>
