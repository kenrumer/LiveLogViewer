<?php

  include ("../common/include/ajax_header.inc");

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
