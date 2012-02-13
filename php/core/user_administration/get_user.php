<?php

  include ("../common/include/ajax_header.inc");

  $user_name = $common->get_query_string($_GET, "user_name");

  $user_attributes = $database->get_user_attributes($user_name);

?>

          <div class="user_administration user_name label">User Name</div>
          <div class="user_administration user_name text_box"><input type="text" id="user_name" name="user_name" value="<?php echo($user_name); ?>" /></div>
          <div class="user_administration display_name label">Display Name</div>
          <div class="user_administration display_name text_box"><input type="text" id="display_name" name="display_name" value="<?php echo($user_attributes['display_name']); ?>"  /></div>
          <div class="user_administration first_name label">First Name</div>
          <div class="user_administration first_name text_box"><input type="text" id="first_name" name="first_name" value="<?php echo($user_attributes['first_name']); ?>"  /></div>
          <div class="user_administration last_name label">Last Name</div>
          <div class="user_administration last_name text_box"><input type="text" id="last_name" name="last_name" value="<?php echo($user_attributes['last_name']); ?>"  /></div>
          <div class="user_administration office label">Office</div>
          <div class="user_administration office text_box"><input type="text" id="office" name="office" value="<?php echo($user_attributes['office']); ?>"  /></div>
          <div class="user_administration department label">Department</div>
          <div class="user_administration department text_box"><input type="text" id="department" name="department" value="<?php echo($user_attributes['department']); ?>"  /></div>
          <div class="user_administration title label">Title</div>
          <div class="user_administration title text_box"><input type="text" id="title" name="title" value="<?php echo($user_attributes['title']); ?>"  /></div>
          <div class="user_administration manager label">Manager</div>
          <div class="user_administration manager text_box"><input type="text" id="manager" name="manager" value="<?php echo($user_attributes['manager']); ?>"  /></div>
          <div class="user_administration email_address label">Email Address</div>
          <div class="user_administration email_address text_box"><input type="text" id="email_address" name="email_address" value="<?php echo($user_attributes['email_address']); ?>"  /></div>
          <div class="user_administration sms_number label">SMS Number</div>
          <div class="user_administration sms_number text_box"><input type="text" id="sms_number" name="sms_number" value="<?php echo($user_attributes['sms_number']); ?>"  /></div>
          <div class="user_administration phone_number label">Phone Number</div>
          <div class="user_administration phone_number text_box"><input type="text" id="phone_number" name="phone_number" value="<?php echo($user_attributes['phone_number']); ?>"  /></div>
          <div class="user_administration cell_phone_number label">Cell Phone Number</div>
          <div class="user_administration cell_phone_number text_box"><input type="text" id="cell_phone_number" name="cell_phone_number" value="<?php echo($user_attributes['cell_phone_number']); ?>"  /></div>
          <div class="user_administration group label">Group</div>
<?php

  $group = $database->get_group_for_user($user_name);

?>
          <div class="user_administration group select">
            <select name="group" id="group">
              <option value="<?php echo($group['id']); ?>"><?php echo($group['name']); ?></option>
<?php

  $groups = $database->get_asc_user_groups();
  foreach($groups as $group) {

?>
              <option value="<?php echo($group['id']); ?>"><?php echo($group['name']); ?></option>
<?php

  }

?>
            </select>
          </div>
          <div class="user_administration ldap_update_button"><input type="button" class="user_administration ldap_update_button" onclick="user_administration_ldap_update_user();" value="ldap update"></div>
          <div class="user_administration remove_button"><input type="button" class="user_administration remove_button" onclick="user_administration_remove_user();" value="Remove" /></div>
          <div class="user_administration save_button"><input type="button" class="user_administration save_button" onclick="user_administration_save_user();" value="Save" /></div>
