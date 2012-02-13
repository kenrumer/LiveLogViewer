<?php

  include ("../common/include/header.inc");

  $type = $common->get_query_string($_GET, "type");
  $id = $common->get_query_string($_GET, "id");

  $item = $database->get_item($type, $id);
  $item_tables = $database->get_item_tables($type, $id);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Infrastructure Management - Item Details Frame
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/infrastructure_management.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="jscript/infrastructure_management.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/css.js" type="text/javascript"></script>
    <script src="/common/jscript/standardista-table-sorting.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel item_details"> 
      <div class="common title blue_steel">
        <span class="common title blue_steel"><?php echo($item['name']) ?></span><img class="common blue_steel title icon" src="<?php echo("/common/images/".$type."ico.png"); ?>" />
      </div>
      <div class="common content blue_steel item_details with_title">
<?php

  foreach ($item_tables as $table) {

?>
        <div id="<?php echo($table); ?>" expanded="false" item_type="<?php echo ($type); ?>_table" item_id="<?php echo $id; ?>" item_table="<?php echo $table; ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($table); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" border="0" id="<?php echo($table); ?>expand" /></a>
          <a class="folder_panel" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($table); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/<?php echo $table; ?>ico.png" id="<?php echo($table); ?>image" alt="<?php echo $type; ?>_<?php echo $table; ?>_table" /></a>
          <a class="folder_panel text" href="#" onclick="infrastructure_management_expand_item(this.parentNode);" id="<?php echo($table); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo $table; ?></a>
        </div>
<?php

  }
?>
      </div>
    </div>
  </body>
</html>
