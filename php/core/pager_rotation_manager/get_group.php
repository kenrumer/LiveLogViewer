<?php

  header('Content-type: text/xml');
  header('Pragma: public');
  header('Cache-control: private');
  header('Expires: -1');

  include ("../common/include/common.inc");
  include ("../common/include/database.inc");
  include ("../common/include/session.inc");

  $common = new common();
  $session = new session();
  $database = new database($session);

  $group_id = $common->get_query_string($_GET, "group_id");

  echo('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'."\n");

  $users = $database->get_users();
  $users_for_group = $database->get_users_for_group($group_id);
  $pager_users = $database->get_pager_users();
  $pager_users_for_group = $database->get_pager_users_for_group($group_id);
  $email_users = $database->get_email_users();
  $email_users_for_group = $database->get_email_users_for_group($group_id);
  $current_position = $database->get_current_position_for_group($group_id);
  $current_user_for_group = $database->get_current_user_for_group($group_id);
  $schedules = $database->get_schedule_for_group($group_id);

  echo("<response>\n");
  if (isset($users)) {
    if (is_array($users)) {
      echo("  <users_count>".count($users)."</users_count>\n");
      echo("  <users>\n");
      foreach($users as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("    </user>\n");
      }
      echo("  </users>\n");
    } else {
      echo("  <users_count>0</users_count>\n");
    }
  } else {
    echo("  <users_count>0</users_count>\n");
  }
  if (isset($users_for_group)) {
    if (is_array($users_for_group)) {
      echo("  <users_for_group_count>".count($users_for_group)."</users_for_group_count>\n");
      echo("  <users_for_group>\n");
      foreach($users_for_group as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("    </user>\n");
      }
      echo("  </users_for_group>\n");
    } else {
      echo("  <users_for_group_count>0</users_for_group_count>\n");
    }
  } else {
    echo("  <users_for_group_count>0</users_for_group_count>\n");
  }
  if (isset($pager_users)) {
    if (is_array($pager_users)) {
      echo("  <pager_users_count>".count($pager_users)."</pager_users_count>\n");
      echo("  <pager_users>\n");
      foreach($pager_users as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("    </user>\n");
      }
      echo("  </pager_users>\n");
    } else {
      echo("  <pager_users_count>0</pager_users_count>\n");
    }
  } else {
    echo("  <pager_users_count>0</pager_users_count>\n");
  }
  echo("  <current_position>".$current_position."</current_position>\n");
  echo("  <current_user_for_group>\n");
  echo("    <user>\n");
  echo("      <userid>".$current_user_for_group[0]['id']."</userid>\n");
  echo("      <first_name>".$current_user_for_group[0]['first_name']."</first_name>\n");
  echo("      <last_name>".$current_user_for_group[0]['last_name']."</last_name>\n");
  echo("    </user>\n");
  echo("  </current_user_for_group>\n");
  if (isset($pager_users_for_group)) {
    if (is_array($pager_users_for_group)) {
      echo("  <pager_users_for_group_count>".count($pager_users_for_group)."</pager_users_for_group_count>\n");
      echo("  <pager_users_for_group>\n");
      foreach($pager_users_for_group as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("      <position>".$user['position']."</position>\n");
        echo ("    </user>\n");
      }
      echo("  </pager_users_for_group>\n");
    } else {
      echo("  <pager_users_for_group_count>0</pager_users_for_group_count>\n");
    }
  } else {
    echo("  <pager_users_for_group_count>0</pager_users_for_group_count>\n");
  }
  if (isset($email_users)) {
    if (is_array($email_users)) {
      echo("  <email_users_count>".count($email_users)."</email_users_count>\n");
      echo("  <email_users>\n");
      foreach($email_users as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("    </user>\n");
      }
      echo("  </email_users>\n");
    } else {
      echo("  <email_users_count>0</email_users_count>\n");
    }
  } else {
    echo("  <email_users_count>0</email_users_count>\n");
  }
  if (isset($email_users_for_group)) {
    if (is_array($email_users_for_group)) {
      echo("  <email_users_for_group_count>".count($email_users_for_group)."</email_users_for_group_count>\n");
      echo("  <email_users_for_group>\n");
      foreach($email_users_for_group as $user) {
        echo ("    <user>\n");
        echo ("      <userid>".$user['id']."</userid>\n");
        echo ("      <first_name>".$user['first_name']."</first_name>\n");
        echo ("      <last_name>".$user['last_name']."</last_name>\n");
        echo ("    </user>\n");
      }
      echo("  </email_users_for_group>\n");
    } else {
      echo("  <email_users_for_group_count>0</email_users_for_group_count>\n");
    }
  } else {
    echo("  <email_users_for_group_count>0</email_users_for_group_count>\n");
  }
  if (isset($schedules)) {
    if (is_array($schedules)) {
      echo("  <schedule_count>".count($schedules)."</schedule_count>\n");
      echo("  <schedules>\n");
      foreach($schedules as $schedule) {
        echo ("    <schedule>\n");
        echo ("      <id>".$schedule['id']."</id>\n");
        echo ("      <type>".$schedule['type']."</type>\n");
        echo ("      <time>".$schedule['time']."</time>\n");
        echo ("      <date>".$schedule['date']."</date>\n");
        echo ("    </schedule>\n");
      }
      echo("  </schedules>\n");
    } else {
      echo("  <schedule_count>0</schedule_count>");
    }
  } else {
    echo("  <schedule_count>0</schedule_count>");
  }
  echo("</response>\n");

?>
