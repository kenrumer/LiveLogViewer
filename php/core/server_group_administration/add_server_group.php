<?php

  include ("../common/include/header.inc");

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Server Group Administration - Add Server Group
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="css/server_group_administration.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/css.js" type="text/javascript"></script>
    <script src="jscript/server_group_administration.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel server_group_administration">
      <div class="common title blue_steel">
        <span class="common title blue_steel">Server Group Administration - Add Server Group</span>
      </div>
      <div class="common content blue_steel with_title">
        <div class="server_group_administration outer_panel">
          <label for="name" class="server_group_administration name">Name</label>
          <div class="server_group_administration name"><input type="text" class="server_group_administration name" id="name" name="name" value="" /></div>
          <label for="description" class="server_group_administration description">Description</label>
          <div class="server_group_administration description"><input type="text" class="server_group_administration description" id="description" name="description" value="" /></div>
          <label for="parent_server_group" class="server_group_administration parent_server_group">Parent Server Group</label>
          <div class="server_group_administration parent_server_group">
            <select name="parent_server_group" id="parent_server_group">
<?php

  $server_groups = $database->get_items("server_group");
  foreach($server_groups as $server_group) {

?>
              <option value="<?php echo ($server_group['id']); ?>">
                <?php echo ($server_group['name'].":".$server_group['description']); ?>
              </option>
<?php

  }

?>
            </select>
          </div>
          <div class="server_group_administration status_panel" id="status_panel"></div>
          <div class="server_group_administration ok_button"><input class="server_group_administration ok_button" type="button" value="OK" onclick="server_group_administration_new_server_group();"></div>
          <div class="server_group_administration cancel_button"><input class="server_group_administration cancel_button" type="button" value="cancel" onclick="server_group_administration_cancel_edit_server_group();"></div>
        </div>
      </div>
    </div>
  </body>
</html>
