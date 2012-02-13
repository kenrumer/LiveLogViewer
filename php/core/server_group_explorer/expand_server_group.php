<?php

  @require_once ("../common/include/ajax_header.inc");

  $id = $common->get_query_string($_GET, 'id');
  $indent = $common->get_query_string($_GET, 'indent');

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

  $server_groups = $database->get_server_groups_in_server_group($id);

  foreach($server_groups as $server_group) {
    $server_group_display_name = $server_group['name'];
    $server_group['name'] = urlencode($server_group['name']);
    $server_group_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $server_group['name']) . "_" . md5(uniqid(rand(), true));

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($server_group_id); ?>" expanded="false" item_type="server_group" item_id="<?php echo($server_group['id']); ?>" item_name="<?php echo($server_group_display_name); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($server_group_id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href2" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/server_groupico.png" id="<?php echo($server_group_id); ?>image"></a>
          <a class="folder_panel server_group text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href3" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($server_group_display_name); ?></a>
        </div>
<?php

  }

  $servers = $database->get_servers_in_server_group($id);

  foreach($servers as $server) {
    $server_display_name = $server['name'];
    $server['name'] = urlencode($server['name']);
    $server_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $server['name']) . "_" . md5(uniqid(rand(), true));

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($server_id); ?>" expanded="false" item_type="server" item_id="<?php echo($server['id']); ?>" item_name="<?php echo($server_display_name); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($server_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($server_id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_id); ?>href2" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/serverico.png" id="<?php echo($server_id); ?>image"></a>
          <a class="folder_panel server text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_id); ?>href3" onContextMenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($server_display_name); ?></a>
        </div>
<?php

  }

?>
