<?php

  include ("../common/include/header.inc");
  include ("calendar.inc");

  $calendar = new Calendar();

  $user_name = $session->get("user_name");
  $groups = $database->get_groups_for_user($user_name);
  if (is_array($groups)) {
    $users = $database->get_users();
    $users_for_group = $database->get_users_for_group($groups[0]['id']);
    $pager_users = $database->get_pager_users();
    $pager_users_for_group = $database->get_pager_users_for_group($groups[0]['id']);
    $email_users = $database->get_email_users();
    $email_users_for_group = $database->get_email_users_for_group($groups[0]['id']);
    $current_position = $database->get_current_position_for_group($groups[0]['id']);
    $current_user_for_group = $database->get_current_user_for_group($groups[0]['id']);
    $schedules = $database->get_schedule_for_group($groups[0]['id']);
  } else {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Pager Rotation Manager
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/pager_rotation_manager.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="jscript/pager_rotation_manager.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    You do not have administrative access on any pager groups.
  </body>
</html>
<?php

    exit(0);
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Pager Rotation Manager
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/pager_rotation_manager.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="jscript/pager_rotation_manager.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common blue_steel background">
      <div class="common blue_steel panel right top">
        <div class="common blue_steel title one_time">
          <span class="common blue_steel title one_time">One time override</span>
        </div>
        <div class="common blue_steel content with_title one_time">
          <select class="pager_rotation_manager one_time group" name="one_time_group">
<?php

  if (is_array($groups)) {
    foreach ($groups as $group) {

?>
            <option value="<?php echo($group['id']); ?>"><?php echo($group['name']); ?></option>
<?php

    }
  }

?>
          </select><br />
          <select class="pager_rotation_manager one_time member" name="one_time_member">
<?php

  if (isset($pager_users)) {
    if (is_array($pager_users)) {
      foreach ($pager_users as $pager_user) {

?>
            <option value="<?php echo($pager_user['id']); ?>"><?php echo($pager_user['first_name']." ".$pager_user['last_name']); ?></option>
<?php

      }
    }
  }

?>
          </select><br />
          <input class="pager_rotation_manager one_time save" type="button" value="Save..." onclick="javascript:save_one_time();" />
        </div>
      </div>
      <div class="common blue_steel panel right bottom">
        <div class="common blue_steel title rules">
          <span class="common blue_steel title rules">Rule Schedule</span>
        </div>
        <div class="common blue_steel content with_title rules">
          <div class="pager_rotation_manager rules group_section">
            <select class="pager_rotation_manager rules group" name="rules_group" id="rules_group" onchange="javascript:change_group(this);">
<?php

  if (is_array($groups)) {
    foreach ($groups as $group) {

?>
            <option value="<?php echo($group['id']); ?>"><?php echo($group['name']); ?></option>
<?php

    }
  }

?>
            </select>
            <span class="pager_rotation_manager rules current_member_text">Current:</span>
<?php

  if (isset($current_user_for_group)) {

?>
            <input disabled class="pager_rotation_manager rules current_member" type="text" name="current_member" id="current_member" value="<?php echo($current_user_for_group[0]['first_name']." ".$current_user_for_group[0]['last_name']); ?>" />
<?php

  } else {

?>
            <input disabled class="pager_rotation_manager rules current_member" type="text" name="current_member" id="current_member" value="" />
<?php

  }

?>
          </div>
          <div class="pager_rotation_manager rules admin_section">
            <span class="pager_rotation_manager rules admin_subtitle">Admin members</span>
            <select class="pager_rotation_manager rules available_member" id="available_admin_member" multiple>
<?php

  function arr_diff($a1, $a2){
    $ar = array();
    foreach ($a1 as $v1) {
      $bFound = false;
      if (is_array($a2)) {
        foreach ($a2 as $v2) {
          if ($v1['id'] == $v2['id']) {
            $bFound = true;
            break;
          }
        }
      }
      if (!$bFound) {
        $ar[] = $v1;
      }
    }
    return $ar;
  }
  if (isset($users)) {
    if (is_array($users)) {
      $diff_array = arr_diff($users, $users_for_group);
      foreach($diff_array as $user) {

?>
              <option value="<?php echo($user['id']); ?>"><?php echo($user['first_name']." ".$user['last_name']); ?></option>
<?php

      }
    }
  }

?>
            </select>
            <input class="pager_rotation_manager rules member add_all_button" onclick="javascript:add_all_admin_members();" type="button" value=">>|>>" title="Add All" />
            <input class="pager_rotation_manager rules member add_button" onclick="javascript:add_selected_admin_member();" type="button" value=">>" title="Add" />
            <input class="pager_rotation_manager rules member remove_button" onclick="javascript:remove_selected_admin_member();" type="button" value="<<" title="Remove" />
            <input class="pager_rotation_manager rules member remove_all_button" onclick="javascript:remove_all_admin_members();" type="button" value="<<|<<" title="Remove All" />
            <input class="pager_rotation_manager rules member save_button" onclick="javascript:save_admin_members();" type="button" value="save" title="Save" />
            <select class="pager_rotation_manager rules selected_member" id="selected_admin_member" multiple>
<?php

  if (isset($users_for_group)) {
    if (is_array($users_for_group)) {
      foreach($users_for_group as $user_for_group) {

?>
              <option value="<?php echo($user_for_group['id']); ?>"><?php echo($user_for_group['first_name']." ". $user_for_group['last_name']); ?></option>
<?php

      }
    }
  }

?>
            </select>
          </div>
          <div class="pager_rotation_manager rules member_section">
            <span class="pager_rotation_manager rules member_subtitle">Paging members</span>
            <select class="pager_rotation_manager rules available_member" id="available_member" multiple>
<?php

  if (isset($pager_users)) {
    if (is_array($pager_users)) {
      $diff_array = arr_diff($pager_users, $pager_users_for_group);
      foreach($diff_array as $user) {

?>
              <option value="<?php echo($user['id']); ?>"><?php echo($user['first_name']." ".$user['last_name']); ?></option>
<?php

      }
    }
  }

?>
            </select>
            <input class="pager_rotation_manager rules member add_all_button" onclick="javascript:add_all_members();" type="button" value=">>|>>" title="Add All" />
            <input class="pager_rotation_manager rules member add_button" onclick="javascript:add_selected_member();" type="button" value=">>" title="Add" />
            <input class="pager_rotation_manager rules member remove_button" onclick="javascript:remove_selected_member();" type="button" value="<<" title="Remove" />
            <input class="pager_rotation_manager rules member remove_all_button" onclick="javascript:remove_all_members();" type="button" value="<<|<<" title="Remove All" />
            <input class="pager_rotation_manager rules member save_button" onclick="javascript:save_members();" type="button" value="save" title="Save" />
            <select class="pager_rotation_manager rules selected_member" id="selected_member" multiple>
            <div class="pager_rotation_manager rules selected_member" id="selected_member">
<?php

  if (isset($pager_users_for_group)) {
    if (is_array($pager_users_for_group)) {
      $found = false;
      foreach($pager_users_for_group as $pager_user_for_group) {
        if ($pager_user_for_group["position"] > $groups[0]["position"]) {
          $found = true;
          break;
        }
      }
      if (!$found) {
        foreach($pager_users_for_group as $pager_user_for_group) {

?>
              <option value="<?php echo($pager_user_for_group['id']); ?>"><?php echo($pager_user_for_group['first_name']." ".$pager_user_for_group['last_name']); ?></option>
<?php

        }
      } else {
        foreach($pager_users_for_group as $pager_user_for_group) {
          if ($pager_user_for_group["position"] > $groups[0]["position"]) {

?>
              <option value="<?php echo($pager_user_for_group['id']); ?>"><?php echo($pager_user_for_group['first_name']." ".$pager_user_for_group['last_name']); ?></option>
<?php

          }
        }
        foreach($pager_users_for_group as $pager_user_for_group) {
          if ($pager_user_for_group["position"] <= $groups[0]["position"]) {

?>
              <option value="<?php echo($pager_user_for_group['id']); ?>"><?php echo($pager_user_for_group['first_name']." ".$pager_user_for_group['last_name']); ?></option>
<?php

          }
        }
      }
    }
  }

?>
            </div>
            </select>
          </div>
          <div class="pager_rotation_manager rules info_section">
            <span class="pager_rotation_manager rules info_subtitle">Informational members</span>
            <select class="pager_rotation_manager rules available_member" id="available_info_member" multiple>
<?php

  if (isset($email_users)) {
    if (is_array($email_users)) {
      $diff_array = arr_diff($email_users, $email_users_for_group);
      foreach($diff_array as $user) {

?>
              <option value="<?php echo($user['id']); ?>"><?php echo($user['first_name']." ".$user['last_name']); ?></option>
<?php

      }
    }
  }

?>
            </select>
            <input class="pager_rotation_manager rules member add_all_button" onclick="javascript:add_all_info_members();" type="button" value=">>|>>" title="Add All" />
            <input class="pager_rotation_manager rules member add_button" onclick="javascript:add_selected_info_member();" type="button" value=">>" title="Add" />
            <input class="pager_rotation_manager rules member remove_button" onclick="javascript:remove_selected_info_member();" type="button" value="<<" title="Remove" />
            <input class="pager_rotation_manager rules member remove_all_button" onclick="javascript:remove_all_info_members();" type="button" value="<<|<<" title="Remove All" />
            <input class="pager_rotation_manager rules member save_button" onclick="javascript:save_info_members();" type="button" value="save" title="Save" />
            <select class="pager_rotation_manager rules selected_member" id="selected_info_member" multiple>
<?php

  if (isset($email_users_for_group)) {
    if (is_array($email_users_for_group)) {
      foreach($email_users_for_group as $email_user_for_group) {

?>
              <option value="<?php echo($email_user_for_group['id']); ?>"><?php echo($email_user_for_group['first_name']." ".$email_user_for_group['last_name']); ?></option>
<?php

      }
    }
  }

?>
            </select>
          </div>
          <div class="pager_rotation_manager rules rules_section">
            <select class="pager_rotation_manager rules rule_name" id="rule_list" multiple>
<?php

  if (isset($schedules)) {
    if (is_array($schedules)) {
      foreach($schedules as $schedule) {

?>
              <option value="<?php echo($schedule['id']); ?>"><?php echo ($schedule['type']." | ".$schedule['time']." | ".$schedule['date']); ?></option>
<?php

      }
    }
  }

?>
            </select>
            <input class="pager_rotation_manager rules rule_name add_button" onclick="javascript:add_rule();" type="button" value="Add..." />
            <input class="pager_rotation_manager rules rule_name edit_button" onclick="javascript:edit_rule();" type="button" value="Edit.." />
            <input class="pager_rotation_manager rules rule_name delete_button" onclick="javascript:delete_rule();" type="button" value="Delete..." /><br />
            <input class="pager_rotation_manager rules rule_name save_button" onclick="javascript:save_rule();" type="button" value="Save..." /><br />
          </div>
          <div class="pager_rotation_manager rules schedule" id="schedule_div">
            <span class="pager_rotation_manager rules recurrence_text">Recurrence</span>
            <input class="pager_rotation_manager rules recurrence_daily" type="radio" checked id="recurrence_daily" name="recurrence" value="d"><span class="pager_rotation_manager rules recurrence_daily_text">Daily</span>
            <input class="pager_rotation_manager rules recurrence_weekly" type="radio" id="recurrence_weekly" name="recurrence" value="w"><span class="pager_rotation_manager rules recurrence_weekly_text">Weekly</span>
            <input class="pager_rotation_manager rules recurrence_monthly" type="radio" id="recurrence_monthly" name="recurrence" value="m"><span class="pager_rotation_manager rules recurrence_monthly_text">Monthly</span>
            <select class="pager_rotation_manager rules recurrence_time" name="time" id="recurrence_time">
              <option value="0000">12:00AM</option>
              <option value="0030">12:30AM</option>
              <option value="0100">1:00AM</option>
              <option value="0130">1:30AM</option>
              <option value="0200">2:00AM</option>
              <option value="0230">2:30AM</option>
              <option value="0300">3:00AM</option>
              <option value="0330">3:30AM</option>
              <option value="0400">4:00AM</option>
              <option value="0430">4:30AM</option>
              <option value="0500">5:00AM</option>
              <option value="0530">5:30AM</option>
              <option value="0600">6:00AM</option>
              <option value="0630">6:30AM</option>
              <option value="0700">7:00AM</option>
              <option value="0730">7:30AM</option>
              <option value="0800">8:00AM</option>
              <option value="0830">8:30AM</option>
              <option value="0900">9:00AM</option>
              <option value="0930">9:30AM</option>
              <option value="1000">10:00AM</option>
              <option value="1030">10:30AM</option>
              <option value="1100">11:00AM</option>
              <option value="1130">11:30AM</option>
              <option value="1200">12:00PM</option>
              <option value="1230">12:30PM</option>
              <option value="1300">1:00PM</option>
              <option value="1330">1:30PM</option>
              <option value="1400">2:00PM</option>
              <option value="1430">2:30PM</option>
              <option value="1500">3:00PM</option>
              <option value="1530">3:30PM</option>
              <option value="1600">4:00PM</option>
              <option value="1630">4:30PM</option>
              <option value="1700">5:00PM</option>
              <option value="1730">5:30PM</option>
              <option value="1800">6:00PM</option>
              <option value="1830">6:30PM</option>
              <option value="1900">7:00PM</option>
              <option value="1930">7:30PM</option>
              <option value="2000">8:00PM</option>
              <option value="2030">8:30PM</option>
              <option value="2100">9:00PM</option>
              <option value="2130">9:30PM</option>
              <option value="2200">10:00PM</option>
              <option value="2230">10:30PM</option>
              <option value="2300">11:00PM</option>
              <option value="2330">11:30PM</option>
            </select>
            <input class="pager_rotation_manager rules start_date" type="text" name="start_date" id="recurrence_start_date" value="<?php echo date("n/j/Y (l)") ?>" />
            <span id="calendar_id">
              <?php echo $calendar->getCurrentMonthView() ?>
            </span>
            <input class="pager_rotation_manager rules validate_button" type="button" value="validate" onclick="javascript:validate_recurrence();" />
            <input class="pager_rotation_manager rules cancel_button" type="button" value="cancel" onclick="javascript:cancel_recurrence();" />
            <input class="pager_rotation_manager rules save_button" type="button" value="add" onclick="javascript:save_recurrence();" />
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
