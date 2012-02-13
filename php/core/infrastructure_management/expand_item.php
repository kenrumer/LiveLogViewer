<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $id = $common->get_query_string($_GET, 'id');
  $indent = $common->get_query_string($_GET, 'indent');
  $table = $common->get_query_string($_GET, 'table', FALSE);

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

  $items = array();
  $item_groups = array();
  switch ($type) {
    case "my_server_root_group":
    case "my_server_group":
      $items = $database->get_items_in_item_group("server", $id);
      $item_groups = $database->get_item_groups_in_item_group("server", $id);
      $subtype = "server";
      $type = "my_server_group";
      break;
    case "server_group":
    case "server_root_group":
      $items = $database->get_items_in_item_group("server", $id);
      $item_groups = $database->get_item_groups_in_item_group("server", $id);
      $subtype = "server";
      $type = "server_group";
      break;
    case "my_application_root_group":
    case "my_application_group":
      $items = $database->get_items_in_item_group("application", $id);
      $item_groups = $database->get_item_groups_in_item_group("application", $id);
      $subtype = "application";
      $type = "my_application_group";
      break;
    case "application_group":
    case "application_root_group":
      $items = $database->get_items_in_item_group("application", $id);
      $item_groups = $database->get_item_groups_in_item_group("application", $id);
      $subtype = "application";
      $type = "application_group";
      break;
    case "my_database_root_group":
    case "my_database_group":
      $items = $database->get_items_in_item_group("database", $id);
      $item_groups = $database->get_item_groups_in_item_group("database", $id);
      $subtype = "database";
      $type = "my_database_group";
      break;
    case "database_group":
    case "database_root_group":
      $items = $database->get_items_in_item_group("database", $id);
      $item_groups = $database->get_item_groups_in_item_group("database", $id);
      $subtype = "database";
      $type = "database_group";
      break;
    case "my_network_root_group":
    case "my_network_group":
      $items = $database->get_items_in_item_group("network", $id);
      $item_groups = $database->get_item_groups_in_item_group("network", $id);
      $subtype = "network";
      $type = "my_network_group";
      break;
    case "network_group":
    case "network_root_group":
      $items = $database->get_items_in_item_group("network", $id);
      $item_groups = $database->get_item_groups_in_item_group("network", $id);
      $subtype = "network";
      $type = "network_group";
      break;
    case "server_table":
      $items = $database->get_item_table_for_item("server", $table, $id);
      $subtype = $table;
      $type = $table;
      break;
  }

  foreach($item_groups as $item_group) {
    $item_group_id = $item_group['id'];
    $item_group_name = $item_group['name'];
    $id = str_replace(array(" ", ".", "-", "/", "\\", ":", "\'"), "", $item_group['name']) . "_" . md5(uniqid(rand(), true));

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($id); ?>" expanded="false" item_type="<?php echo($type); ?>" item_id="<?php echo($item_group_id); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/<?php echo($type); ?>ico.png" id="<?php echo($id); ?>image" alt="<?php echo($type); ?>"></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($item_group_name); ?></a>
        </div>
<?php

  }

  foreach($items as $item) {
        $item_id = $item['id'];
        $item_name = $item['name'];
    $id = str_replace(array(" ", ".", "-", "/", "\\", ":", "\'"), "", $item['name']) . "_" . md5(uniqid(rand(), true));

?>
        <div style="text-indent: <?php echo($icon_indent); ?>pt" id="<?php echo($id); ?>" item_type="<?php echo($subtype); ?>" item_id="<?php echo($item_id); ?>">
          <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href2" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/<?php echo($subtype); ?>ico.png" id="<?php echo($id); ?>image" alt="<?php echo($subtype); ?>"></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($item_name); ?></a>
        </div>
<?php

  }

?>
