<?php

  @require_once("../common/include/header.inc");

  $id = $common->get_query_string($_GET, 'server_id');
  $server = $database->get_server($id);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      <?php echo ($server); ?> Properties
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="css/server_group_explorer.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js" type="text/javascript"></script>
    <script src="jscript/server_group_explorer.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common blue_steel background">
      <div class="common blue_steel content">
        <pre>
<?php

  if (isset($_SERVER['HTTPS'])) {
    @require ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_process_info.php");
  } else {
    @require ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_process_info.php");
  }

?>
        </pre>
      </div>
    </div>
  </body>
</html>
