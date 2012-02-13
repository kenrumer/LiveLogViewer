<?php

  include ("../common/include/header.inc");

  //$group = $database->get_group_for_user($session->get("user_name"));
  //if ($group['id'] != 1) {
    //echo "Not an admin";
    //exit(0);
  //}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Infrastructure Management
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/infrastructure_management.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js" type="text/javascript"></script>
    <script src="jscript/infrastructure_management.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel search">
      <div class="common title blue_steel">
        <span class="common title blue_steel">Search</span>
      </div>
      <div class="common content blue_steel search with_title">
        <select class="infrastructure_management search type" id="type_list">
          <option value="server">Server</option>
          <option value="database">Database</option>
          <option value="application">Application</option>
          <option value="network">Network</option>
        </select>
        <input class="infrastructure_management search textbox" type="text" id="search_textbox" />
        <input class="infrastructure_management search button" type="image" src="/infrastructure_management/images/search_frame_search_button.png" id="search_button" onclick="infrastructure_management_search_items(document.getElementById('search_textbox').value, document.getElementById('type_list').value);" />
        <select class="infrastructure_management search recent_searches" id="recent_searches">
          <option>Recent Searches</option>
        </select>
      </div>
    </div>
    <div class="common panel blue_steel output">
      <div class="common content blue_steel nav_explorer" id="menu_panel">
<?php

  if (isset($group)) {
    $my_server_group_id = "MyServerGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($my_server_group_id); ?>" expanded="false" item_type="my_server_root_group" item_id="<?php echo $database->get_my_item_group_id("server", $session->get("user_name")); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($my_server_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_server_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/my_server_groupico.png" id="<?php echo($my_server_group_id); ?>image" alt="my_server_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_server_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">My Server Groups</a>
        </div>
<?php

    $my_application_group_id = "MyApplicationGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($my_application_group_id); ?>" expanded="false" item_type="my_application_root_group" item_id="<?php echo $database->get_my_item_group_id("application", $session->get("user_name")); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_application_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($my_application_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_application_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/my_application_groupico.png" id="<?php echo($my_application_group_id); ?>image" alt="my_application_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_application_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">My Application Groups</a>
        </div>
<?php

    $my_database_group_id = "MyDatabaseGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($my_database_group_id); ?>" expanded="false" item_type="my_database_root_group" item_id="<?php echo $database->get_my_item_group_id("database", $session->get("user_name")); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_database_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($my_database_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_database_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/my_database_groupico.png" id="<?php echo($my_database_group_id); ?>image" alt="my_database_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_database_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">My Database Groups</a>
        </div>
<?php

    $my_network_group_id = "MyNetworkGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($my_network_group_id); ?>" expanded="false" item_type="my_network_root_group" item_id="<?php echo $database->get_my_item_group_id("network", $session->get("user_name")); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_network_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($my_network_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_network_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/my_network_groupico.png" id="<?php echo($my_network_group_id); ?>image" alt="my_network_group" /></a>
           <a class="folder_panel text" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($my_network_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">My Network Groups</a>
        </div>
<?php

  }
  $server_group_id = "ServerGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($server_group_id); ?>" expanded="false" item_type="server_root_group" item_id="1" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($server_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($server_group_id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/server_groupico.png" id="<?php echo($server_group_id); ?>image" alt="server_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($server_group_id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">Server Groups</a>
        </div>
<?php

  $application_group_id = "ApplicationGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($application_group_id); ?>" expanded="false" item_type="application_root_group" item_id="1" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($application_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($application_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($application_group_id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/application_groupico.png" id="<?php echo($application_group_id); ?>image" alt="application_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($application_group_id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">Application Groups</a>
        </div>
<?php

  $database_group_id = "DatabaseGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($database_group_id); ?>" expanded="false" item_type="database_root_group" item_id="1" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($database_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($database_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($database_group_id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/database_groupico.png" id="<?php echo($database_group_id); ?>image" alt="database_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($database_group_id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">Database Groups</a>
        </div>
<?php

  $network_group_id = "NetworkGroups_" . md5(uniqid(rand(), true));

?>
        <div id="<?php echo($network_group_id); ?>" expanded="false" item_type="network_root_group" item_id="1" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($network_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($network_group_id); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($network_group_id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/network_groupico.png" id="<?php echo($network_group_id); ?>image" alt="network_group" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($network_group_id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);">Network Groups</a>
        </div>
      </div>
    </div>
    <div class="folder_panel my_server_root_group context_menu" id="my_server_root_group_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_expand_item');" title="Expand this item"><b>Expand</b></a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" title="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_properties');" title="Display standard properties of the server group">Properties</a>
    </div>
    <div class="folder_panel my_server_group context_menu" id="my_server_group_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_show_item_list');" title="Show Server List"><b>Show Server List</b></a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_expand_item');" title="Expand this item">Expand</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_open_item');" title="View filesystem on this server group">File Viewer</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_remove_my_group');" title="Remove Group..."><img class="context_menu icon" src="/common/images/remove_server_groupico.png" title="Remove Group" />Remove Group...</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" title="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_properties');" title="Display standard properties of the server group">Properties</a>
    </div>
    <div class="folder_panel server_group context_menu" id="server_group_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_show_item_list');" title="Show Server List"><b>Show Server List</b></a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_expand_item');" title="Expand this item">Expand</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_open_item');" title="View filesystem on this server group">File Viewer</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_create_group');" title="Create Group..."><img class="context_menu icon" src="/common/images/add_server_groupico.png" title="Create Group" />Create Group...</a>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_remove_group');" title="Remove Group..."><img class="context_menu icon" src="/common/images/remove_server_groupico.png" title="Remove Group" />Remove Group...</a>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_add_item_to_item_group');" title="Add Servers To Group..."><img class="context_menu icon" src="/common/images/add_serverico.png" title="Add Servers To Group" />Add Servers To Group...</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_add_to_my_server_group');" title="Add to My Group..."><img class="context_menu icon" src="/common/images/add_to_my_server_groupico.png" title="Add to My Server Group" />Add to My Group...</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" title="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_properties');" title="Display standard properties of the server group">Properties</a>
    </div>
    <div class="folder_panel server context_menu" id="server_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_show_item_list');" title="Show Server Details"><b>Show Server Details</b></a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_open_item');" title="View filesystem on this server">File Viewer</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('compare_items_add_item');" title="Compare this server">Compare Server</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_add_server_to_group');" title="Add To Group..."><img class="context_menu icon" src="/common/images/add_serverico.png" title="Add To Group" />Add To Group...</a>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_remove_server_from_group');" title="Remove From Group..."><img class="context_menu icon" src="/common/images/remove_serverico.png" title="Remove From Group" />Remove From Group...</a>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_add_path_to_server');" title="Add path(s) to server"><img class="context_menu icon" src="/common/images/directoryico.png" title="Add path(s) to server" />Add path(s) to server...</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" title="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_properties');" title="Display standard properties of the server group">Properties</a>
    </div>
    <div class="common blue_steel panel menu">
      <div class="common blue_steel content">
        <div class="infrastructure_management blue_steel nav_menu">
          <a class="infrastructure_management menu_item blue_steel A selected" name="Groups" href="#" onclick="infrastructure_management_set_selected(this);" item_page="/common/blank.html" item_menu="/infrastructure_management/show_groups_menu.php" id="infrastructure_management_nav_menu_groups">
            <span class="infrastructure_management menu_item blue_steel align_middle">Groups</span>
          </a>
          <a class="infrastructure_management menu_item blue_steel B" name="Library" href="#" onclick="infrastructure_management_set_selected(this);" item_page="/software_management/index.php" item_menu="/software_management/show_library_menu.php" id="infrastructure_management_nav_menu_library">
            <span class="infrastructure_management menu_item blue_steel align_middle">Library</span>
          </a>
          <a class="infrastructure_management blue_steel menu_item blue_steel C" name="Reports" href="#" onclick="infrastructure_management_set_selected(this);" item_page="/reports/index.php" item_menu="/reports/show_reports_menu.php" id="infrastructure_management_nav_menu_reports">
            <span class="infrastructure_management menu_item blue_steel align_middle">Reports</span>
          </a>
          <a class="infrastructure_management blue_steel menu_item blue_steel D" name="Jobs and Sessions" href="#" onclick="infrastructure_management_set_selected(this);" item_page="/scheduler/index.php" item_menu="/scheduler/show_jobs_and_sessions_menu.php" id="infrastructure_management_nav_menu_jobs_and_sessions">
            <span class="infrastructure_management menu_item blue_steel align_middle">Jobs and Sessions</span>
          </a>
          <a class="infrastructure_management blue_steel menu_item blue_steel E" name="ASC Administration" href="#" onclick="infrastructure_management_set_selected(this);" item_page="/asc_administration/index.php" item_menu="/asc_administration/show_asc_administration_menu.php" id="infrastructure_management_nav_menu_asc_administration">
            <span class="infrastructure_management menu_item blue_steel align_middle">ASC Administration</span>
          </a>
        </div>
      </div>
    </div>
    <div class="common blue_steel panel right_top">
      <div class="common blue_steel content without_title right">
        <iframe class="infrastructure_management output_frame" id="output_frame" name="output_frame" src="/common/blank.html"></iframe>
      </div>
    </div>
  </body>
</html>
