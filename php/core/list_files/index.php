<?php

  @require_once("../common/include/header.inc");

  $server_id = $common->get_query_string($_GET, 'server_id');
  $path = $common->get_query_string($_GET, 'path');

  $server = $database->get_server($server_id);

  if (isset($_SERVER['HTTPS'])) {
    @require ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_file_list.php?path=".urlencode($path));
  } else {
    @require ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_file_list.php?path=".urlencode($path));
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - File Explorer - File List View - <?php echo($server['name']); ?>:<?php echo($path); ?>
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/sorttable.css" type="text/css" />
    <link rel="stylesheet" href="css/list_files.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <script src="/common/jscript/sorttable.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/file_explorer/jscript/file_explorer.js" type="text/javascript"></script>
    <script src="jscript/list_files.js" type="text/javascript"></script>
  </head>
  <body>
    <table class="sortable" id="fileList" width="100%" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th>
            &nbsp;
          </th>
          <th sortable="true" class="sortheader">
            Name
          </th>
          <th sortable="true" class="sortheader">
            In Folder
          </th>
          <th sortable="true" class="sortheader">
            Size
          </th>
          <th sortable="true" class="sortheader">
            Date Modified
          </th>
        </tr>
      </thead>
      <tbody>
<?php

  foreach ($_FILES[$server['fqdn']][$path] as $file => $attribs) {
    $path_file = addslashes($path.$file);

?>
        <tr onContextMenu="return context_menu_show_context_menu(this);" item_type="file" item_id="<?php echo($server_id); ?>" item_path="<?php echo($path_file); ?>">
          <td class="list_files file_name" onclick="file_explorer_open_item(this.parentNode);">
            <img class="list_files icon" src="/common/images/fileico.png" />
          </td>
          <td class="list_files file_name" onclick="file_explorer_open_item(this.parentNode);">
            &nbsp;&nbsp;<?php echo($file); ?>
          </td>
          <td class="list_files file_name">
            &nbsp;&nbsp;<?php echo($path); ?>
          </td>
          <td class="list_files align_right" sorttable_customkey="<?php echo ($attribs['size']); ?>">
            <?php echo($common->byte_convert($attribs['size'])); ?>&nbsp;&nbsp;
          </td>
          <td sorttable_customkey="<?php echo ($attribs['mtime']); ?>">
             &nbsp;&nbsp;<?php echo(strftime("%m/%d/%Y %H:%M:%S", $attribs['mtime'])); ?>
          </td>
        </tr>
<?php
  }
?>
      </tbody>
    </table>
    <div class="list_files file context_menu" id="file_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('file_explorer_open_item');" title="Open File"><b>Open File</b></a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('file_explorer_tail_file');" title="Tail this file">Tail File</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('compare_items_add_item');" title="Compare this file">Compare File</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_download_item();" title="Download this item"><img class="context_menu icon" src="/common/images/download_folderico.png" alt="Download" />Download File</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('file_explorer_show_properties');" title="Display standard properties of the directory">Properties</a>
    </div>
  </body>
</html>
