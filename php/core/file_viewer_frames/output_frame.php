<?php

  @require_once ("../common/include/header.inc");

  $path = $common->get_query_string($_GET, 'path');
  $server_id = $common->get_query_string($_GET, 'server_id');
  $server = $database->get_server($server_id);
  $tail = $common->get_query_string($_GET, 'tail', FALSE);
  if (!isset($tail)) {
    $tail = FALSE;
  }
  if ($tail == "false") {
    $tail = FALSE;
  }

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
    <link rel="stylesheet" href="/access/css/access.css" />
    <link rel="stylesheet" href="css/file_viewer.css" />
    <script language="javascript">
      var file_info='<?php echo($file_info); ?>';
      var btail=<?php if ($tail) { echo ("true"); } else { echo ("false"); } ?>;
      var strPath = "<?php echo(addslashes($path)); ?>";
      var file_pos = "<?php echo($file_size); ?>";
      var nServer_id = "<?php echo($server_id); ?>";
      var strFileName = "<?php echo(basename($path)); ?>";
    </script>
    <script src="/common/jscript/ajax.js"></script>
    <script src="/access/jscript/access.js"></script>
    <script src="jscript/file_viewer.js"></script>
<?php

  if ($file_size > $session->get("file_size_limit", "file_explorer")) {
    echo ("   <script language=\"javascript\">");
    echo ("      alert(\"file size ".$common->byte_convert($file_size)." is > ".$common->byte_convert($session->get("file_size_limit", "file_explorer"))." limit, truncating first ".$common->byte_convert($file_size - $session->get("file_size_limit", "file_explorer"))."\");");
    echo ("</script>");
  }

?>
  </head>
  <body style="height: 100%;">
    <div class="file_viewer blue_steel panel content" id="content">
<pre>
<?php
  if (isset($_SERVER['HTTPS'])) {
    @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server['fqdn'].'/get_file.php?path='.urlencode($path).'&limit='.$session->get("file_size_limit", "file_explorer"));
  } else {
    @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server['fqdn'].'/get_file.php?path='.urlencode($path).'&limit='.$session->get("file_size_limit", "file_explorer"));
  }
?>

</pre>
    </div>
  </body>
</html>
