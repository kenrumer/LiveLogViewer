<?php

  include ("../common/include/header.inc");

?><!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - User Administration
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="css/user_administration.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/css.js" type="text/javascript"></script>
    <script src="jscript/user_administration.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel user_administration">
      <div class="common title blue_steel">
        <span class="common title blue_steel">User Administration</span>
      </div>
      <div class="common content blue_steel with_title">
        <select name="user_id" id="user_id" onchange="user_administration_update_user();">
          <option value="asc_new_user">New User...</option>
<?php

  $users = $database->get_asc_users();
  foreach($users as $user) {

?>
          <option value="<?php echo $user['user_name']; ?>"><?php echo $user['first_name']." ".$user['last_name']; ?></option>
<?php

  }

?>
        </select>
        <div id="user_fields">
          <div class="user_administration user_name label">User Name</div>
          <div class="user_administration user_name text_box"><input type="text" id="user_name" name="user_name" /></div>
          <div class="user_administration add_button"><input class="user_administration add_button" type="button" value="Add..." onclick="user_administration_add_user();"></div>
        </div>
        <div id="user_info" style="display:none;">
          <div class="user_administration user_name label">User Name</div>
          <div class="user_administration user_name text_box"><input type="text" id="user_name" name="user_name" /></div>
          <div class="user_administration display_name label">Display Name</div>
          <div class="user_administration display_name text_box"><input type="text" id="display_name" name="display_name" /></div>
          <div class="user_administration first_name label">First Name</div>
          <div class="user_administration first_name text_box"><input type="text" id="first_name" name="first_name" /></div>
          <div class="user_administration initials label">Initails</div>
          <div class="user_administration initials text_box"><input type="text" id="initials" name="initials" /></div>
          <div class="user_administration last_name label">Last Name</div>
          <div class="user_administration last_name text_box"><input type="text" id="last_name" name="last_name" /></div>
          <div class="user_administration office label">Office</div>
          <div class="user_administration office text_box"><input type="text" id="office" name="office" /></div>
          <div class="user_administration department label">Department</div>
          <div class="user_administration department text_box"><input type="text" id="department" name="department" /></div>
          <div class="user_administration title label">Title</div>
          <div class="user_administration title text_box"><input type="text" id="title" name="title" /></div>
          <div class="user_administration manager label">Manager</div>
          <div class="user_administration manager text_box"><input type="text" id="manager" name="manager" /></div>
          <div class="user_administration email_address label">Email Address</div>
          <div class="user_administration email_address text_box"><input type="text" id="email_address" name="email_address" /></div>
          <div class="user_administration sms_number label">SMS Number</div>
          <div class="user_administration sms_number text_box"><input type="text" id="sms_number" name="sms_number" /></div>
          <div class="user_administration phone_number label">Phone Number</div>
          <div class="user_administration phone_number text_box"><input type="text" id="phone_number" name="phone_number" /></div>
          <div class="user_administration cell_phone_number label">Cell Phone Number</div>
          <div class="user_administration cell_phone_number text_box"><input type="text" id="cell_phone_number" name="cell_phone_number" /></div>
          <div class="user_administration group label">Group</div>
          <div class="user_administration group text_box"><input type="text" id="group" name="group" /></div>
          <div class="user_administration ldap_update_button"><input type="button" class="user_administration ldap_update_button" onclick="user_administration_ldap_update_user();" value="ldap update"></div>
          <div class="user_administration remove_button"><input type="button" class="user_administration remove_button" onclick="user_administration_remove_user();" value="Remove" /></div>
          <div class="user_administration save_button"><input type="button" class="user_administration save_button" onclick="user_administration_save_user();" value="Save" /></div>
        </div>
      </div>
    </div>
  </body>
</html>
