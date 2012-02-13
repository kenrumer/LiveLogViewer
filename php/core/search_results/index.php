<?php

  @require_once ("../common/include/header.inc");

  set_time_limit(0);

  $server_ids = $common->get_post_string($_POST, 'server_ids');
  $path = $common->get_post_string($_POST, 'path');
  $depth = $common->get_post_string($_POST, 'depth');
  $search_file_name = $common->get_post_string($_POST, 'search_file_name', FALSE);
  $search_text = $common->get_post_string($_POST, 'search_text', FALSE);
  $search_date = $common->get_post_string($_POST, 'search_date', FALSE);
  $search_date_low = $common->get_post_string($_POST, 'search_date_low', FALSE);
  $search_date_high = $common->get_post_string($_POST, 'search_date_high', FALSE);
  $search_size = $common->get_post_string($_POST, 'search_size', FALSE);
  $search_size_type = $common->get_post_string($_POST, 'search_size_type', FALSE);
  $search_size_value = $common->get_post_string($_POST, 'search_size_value', FALSE);

  $servers = array();
  foreach($server_ids as $server_id) {
    $servers[] = $database->get_server($server_id);
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC Explorer - Search Results
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/explorer/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/sorttable.css" type="text/css" />
    <link rel="stylesheet" href="css/search_results.css" type="text/css" />
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/sorttable.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/file_explorer/jscript/file_explorer.js" type="text/javascript"></script>
    <script src="jscript/search_results.js" type="text/javascript"></script>
  </head>
  <body>
    <table class="sortable" id="fileList" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <th>
          &nbsp;
        </th>
        <th sortable="true" class="sortheader">
          Server
        </th>
        <th sortable="true" class="sortheader">
          In Folder
        </th>
        <th sortable="true" class="sortheader">
          Name
        </th>
<?php

  if ($search_text) {

?>
        <th sortable="true" class="sortheader">
          Count
        </th>
<?php

    }

?>
        <th sortable="true" class="sortheader">
          Size
        </th>
        <th sortable="true" class="sortheader">
          Date modified
        </th>
    </tr>
<?php


  foreach ($servers as $server) {

    if (isset($_SERVER['HTTPS'])) {
      @require ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_search_results.php?path=".urlencode($path)."&depth=".$depth."&search_file_name=".urlencode($search_file_name)."&search_text=".urlencode($search_text)."&search_date=".$search_date."&search_date_low=".$search_date_low."&search_date_high=".$search_date_high."&search_size=".$search_size."&search_size_type=".$search_size_type."&search_size_value=".$search_size_value);
    } else {
      require ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_search_results.php?path=".urlencode($path)."&depth=".$depth."&search_file_name=".urlencode($search_file_name)."&search_text=".urlencode($search_text)."&search_date=".$search_date."&search_date_low=".$search_date_low."&search_date_high=".$search_date_high."&search_size=".$search_size."&search_size_type=".$search_size_type."&search_size_value=".$search_size_value);
    }

    if (is_array($_FILES[$server['fqdn']][$path])) {
      foreach ($_FILES[$server['fqdn']][$path] as $file => $attribs) {
        $file_name = addslashes($file);
        $path_id = str_replace(array(" ",".", "-", "/", "\\", ":", "'"), "", $file) . "_" . md5(uniqid(rand(), true));

?>
        <tr onContextMenu="return context_menu_show_context_menu(this);" item_type="file" item_id="<?php echo($server_id); ?>" item_path="<?php echo($file); ?>">
          <td class="search_results file_name" onclick="file_explorer_open_item(this.parentNode);">
            <img class="search_results icon" src="/common/images/fileico.png" />
          </td>
          <td class="search_results file_name" onclick="file_explorer_open_item(this.parentNode);">
            <?php echo($server['name']); ?>
          </td>
          <td class="search_results file_name" onclick="file_explorer_open_item(this.parentNode);">
            &nbsp;&nbsp;<?php echo(dirname($file)); ?>
          </td>
          <td class="search_results file_name" onclick="file_explorer_open_item(this.parentNode);">
            &nbsp;&nbsp;<?php echo(basename($file)); ?>
          </td>
<?php

        if ($search_text) {

?>
          <td>
            <?php echo($attribs['count']); ?>
          </td>
<?php

        }

?>
          <td class="search_results align_right" sorttable_customkey="<?php echo ($attribs['size']); ?>">
            <?php echo($common->byte_convert($attribs['size'])); ?>&nbsp;&nbsp;
          </td>
          <td sorttable_customkey="<?php echo ($attribs['mtime']); ?>">
             &nbsp;&nbsp;<?php echo(strftime("%m/%d/%Y %H:%M:%S", $attribs['mtime'])); ?>
          </td>
        </tr>
<?php

        if ($search_text) {

?>
      <tr>
        <td colspan="7" bgcolor="#D6DFF7">
          <div id="<?php echo($path_id) ?>"><a href="javascript:search_results_show_grep('<?php echo($file_name) ?>', '<?php echo($server['id']); ?>', '<?php echo($search_text) ?>', '<?php echo($path_id) ?>');"><img id="<?php echo($path_id) ?>expand" border="0" src="/common/images/plusico.png"><font style="position: relative; top: -3px;"> Show matching text</font></a><div id="<?php echo($path_id) ?>results"></div></div>
        </td>
      </tr>
<?php

        }
      }
    }
  }

?>
    </table>
    <div class="search_results file context_menu" id="file_context_menu">
      <a class="context_menu indent" href="javascript:context_menu_show_item_details();return false;" title="Show Details"><b>Show Details</b></a>
      <a class="context_menu indent" href="javascript:context_menu_tail_file();return false;" title="Tail this file">Tail File</a>
      <a class="context_menu indent" href="javascript:context_menu_compare_item();return false;" title="Compare this file">Compare File</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="javascript:context_menu_download_item();return false;" title="Download this item"><img class="context_menu icon" src="/common/images/download_folderico.png" alt="Download" />Download File</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="javascript:history.go(0);return false;" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="javascript:context_menu_properties();return false;" title="Display standard properties of the directory">Properties</a>
    </div>
  </body>
</html>
