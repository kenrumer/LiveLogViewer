<?php

  @require_once ("../common/include/header.inc");

  $path = $common->get_query_string($_GET, 'path');
  $server_id = $common->get_query_string($_GET, 'server_id');
  $server = $database->get_server($server_id);

  if (isset($_SERVER['HTTPS'])) {
    @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server['fqdn'].'/get_file_info.php?path='.urlencode($path));
  } else {
    @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server['fqdn'].'/get_file_info.php?path='.urlencode($path));
  }

  $file_info = "<table class=\"file_viewer\"><tr><th class=\"file_viewer\">".$server['name']."</th><th class=\"file_viewer\">".$path."</th><th class=\"file_viewer\">".$attribs['nlink']."</th><th class=\"file_viewer\">";
  if ($attribs['uid'] != 0) {
    $file_info = $file_info.$attribs['uid']."</th><th class=\"file_viewer\">".$attribs['gid']."</th><th class=\"file_viewer\">";
  }
  $file_info = $file_info.$common->byte_convert($attribs['size'])."</th><th class=\"file_viewer\">".strftime("%m/%d/%Y %H:%M:%S", $attribs['mtime'])."</th><th class=\"file_viewer\">".$basename."</th></tr></table>";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC Explorer - File Viewer - <?php echo($server['name'].":".$path); ?>
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" />
    <link rel="stylesheet" href="css/file_viewer.css" />
    <script src="jscript/file_viewer.js"></script>
  </head>
  <body style="height: 100%;">
    <div class="file_viewer blue_steel panel bottom" id="bottom">
      &nbsp;<?php echo($file_info); ?>
    </div>
  </body>
</html>
