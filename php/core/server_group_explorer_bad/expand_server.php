<?php

  @require_once ("../common/include/ajax_header.inc");

  $id = $common->get_query_string($_GET, 'id');
  $indent = $common->get_query_string($_GET, 'indent');

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

  $paths = $database->get_paths_in_server($id);

  foreach($paths as $path) {
    if ($path['is_root']) {
      $path_display_name = $path['name'];
      $path_id = str_replace(array(" ", ".", "-", "/", ":", "\'"), "", $path['name']) . "_" . md5(uniqid(rand(), true));
      $path['name'] = addslashes($path['name']);
      if ($path['is_directory']) {

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($path_id); ?>" expanded="false" item_type="directory" item_id="<?php echo($id); ?>" item_path="<?php echo($path['name']); ?>" item_path_id="<?php echo($path_id); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($path_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($path_id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href2" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/directoryico.png" id="<?php echo($path_id); ?>image"></a>
          <a class="folder_panel directory text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href3" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($path_display_name); ?></a>
        </div>
<?php

      } else {

?>
        <div style="text-indent: <?php echo($icon_indent); ?>pt" id="<?php echo($path_id); ?>" item_type="file" item_id="<?php echo($id); ?>" item_path="<?php echo($path['name']); ?>" item_path_id="<?php echo($path_id); ?>" item_indent="<?php echo($indent); ?>" item_tail="false">
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href2" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/fileico.png" id="<?php echo($path_id); ?>image"></a>
          <a class="folder_panel file text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href3" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($path['name']); ?></a>
        </div>
<?php

      }
    }
  }

?>
