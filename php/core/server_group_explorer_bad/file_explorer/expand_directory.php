<?php

  @require_once ("../common/include/ajax_header.inc");

  $id = $common->get_query_string($_GET, 'id');
  $server = $database->get_server($id);
  $path = $common->get_query_string($_GET, 'path');
  $indent = $common->get_query_string($_GET, 'indent');

  require ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_directory_contents.php?paths=".urlencode($path));
  //echo ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_directory_contents.php?paths=".urlencode($path));

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

  $deny_paths = $database->get_server_denied_paths($id);

  if (array_key_exists("directories", $_DIR_CONTENT[$server['fqdn']][$path])) {
    foreach ($_DIR_CONTENT[$server['fqdn']][$path]['directories'] as $content => $attribs) {
      if (!in_array($path.$content."/", $deny_paths)) {
        $path_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $path.$content) . "_" . md5(uniqid(rand(), true));
        $subpath = $path.$content.'/';
        if ($attribs['has_subcontents']) {

?>
        <div style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($path_id); ?>" expanded="false" item_type="directory" item_id="<?php echo($id); ?>" item_path="<?php echo($subpath); ?>" item_path_id="<?php echo($path_id); ?>" item_indent="<?php echo($indent); ?>">
          <a class="folder_panel" href="#" onclick="file_explorer_expand_item(this.parentNode);" id="<?php echo($path_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($path_id); ?>expand" alt="+" /></a>
<?php

        } else {

?>
        <div style="text-indent: <?php echo($icon_indent); ?>pt" id="<?php echo($path_id); ?>" item_type="directory" item_id="<?php echo($id); ?>" item_path="<?php echo($subpath); ?>" item_path_id="<?php echo($path_id); ?>">
<?php

        }

?>
          <a class="folder_panel" href="#" onclick="file_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel blue_steel directory icon" src="/common/images/directoryico.png" id="<?php echo($path_id); ?>image"></a>
          <a class="folder_panel directory text" href="#" onclick="file_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($content); ?></a>
        </div>
<?php

      }
    }
  }
  if (is_array($_DIR_CONTENT[$server['fqdn']][$path])) {
    if (array_key_exists("files", $_DIR_CONTENT[$server['fqdn']][$path])) {
      foreach ($_DIR_CONTENT[$server['fqdn']][$path]['files'] as $content => $attribs) {
        if (!in_array($path.$content, $deny_paths)) {
          $path_id = str_replace(array(" ", ".", "-", "/", ":", "\'"), "", $content) . "_" . md5(uniqid(rand(), true));
          $subpath = $path.$content;
          $path_display_name = $subpath;

?>
        <div style="text-indent: <?php echo($icon_indent); ?>pt" id="<?php echo($path_id); ?>" item_type="file" item_id="<?php echo($id); ?>" item_path="<?php echo($subpath); ?>" item_path_id="<?php echo($path_id); ?>" item_tail="false">
          <a class="folder_panel" href="#" onclick="file_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel blue_steel file icon" src="/common/images/fileico.png" id="<?php echo($path_id); ?>image"></a>
          <a class="folder_panel file text" href="#" onclick="file_explorer_open_item(this.parentNode);" id="<?php echo($path_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($content); ?></a>
        </div>
<?php

        }
      }
    }
  }

?>
