<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');
  $indent = $common->get_query_string($_GET, 'indent');
  $name = $common->get_query_string($_GET, 'name');

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

  switch ($type) {
    case "my_server_root_group":
    case "server_group":
    case "server_root_group":
      $item_group_id = $database->add_item_group_to_item_group("server", $id, $name);
      break;
    case "my_application_root_group":
    case "application_group":
    case "application_root_group":
      $item_group_id = $database->add_item_group_to_item_group("application", $id, $name);
      break;
    case "my_database_root_group":
    case "database_group":
    case "database_root_group":
      $item_group_id = $database->add_item_group_to_item_group("database", $id, $name);
      break;
    case "my_network_root_group":
    case "network_group":
    case "network_root_group":
      $item_group_id = $database->add_item_group_to_item_group("network", $id, $name);
      break;
  }

  $id = str_replace(array(" ", ".", "-", "/", "\\", ":", "\'"), "", $name) . "_" . md5(uniqid(rand(), true));

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($id); ?>" expanded="false" item_type="<?php echo($type); ?>" item_id="<?php echo($item_group_id); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/<?php echo($type); ?>ico.png" id="<?php echo($id); ?>image" alt="<?php echo($type); ?>"></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($name); ?></a>
        </div>
