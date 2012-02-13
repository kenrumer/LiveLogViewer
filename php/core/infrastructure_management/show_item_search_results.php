<?php

  include ("../common/include/ajax_header.inc");

  $type = $common->get_query_string($_GET, 'type'); 
  $name = $common->get_query_string($_GET, 'name'); 

  $items = $database->get_items_by_name($type, $name);

  foreach ($items as $item) {

?>
  <div id="<?php echo $item['id']; ?>" item_type="<?php echo $type; ?>" item_id="<?php echo $item['id']; ?>">
    <a class="folder_panel" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/<?php echo($type); ?>ico.png" id="<?php echo($id); ?>image" alt="<?php echo($type); ?>"></a>
    <a class="folder_panel text" href="#" onclick="infrastructure_management_show_item_list(this.parentNode);" id="<?php echo($id); ?>href3" ondblclick="infrastructure_management_open_item(this.parentNode);" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo $item['name']; ?></a>
  </div>
<?php

  }

?>
