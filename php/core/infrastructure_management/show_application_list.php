<?php

  include ("../common/include/header.inc");

  $type = $common->get_query_string($_GET, "type");
  $id = $common->get_query_string($_GET, "id");

  switch ($type) {
    case "server_group":
      $item_group = $database->get_item_group_name("server", $id);
      $items = $database->get_items_in_item_group("server", $id);
      $subtype = "server";
      break;
    case "application_group":
      $item_group = $database->get_item_group_name("application", $id);
      $items = $database->get_items_in_item_group("application", $id);
      $subtype = "application";
      break;
    case "database_group":
      $item_group = $database->get_item_group_name("database", $id);
      $items = $database->get_items_in_item_group("database", $id);
      $subtype = "database";
      break;
    case "network_group":
      $item_group = $database->get_item_group_name("network", $id);
      $items = $database->get_items_in_item_group("network", $id);
      $subtype = "network";
      break;

  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Infrastructure Management - Item List Frame
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/explorer.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/infrastructure_management.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/common/jscript/sorttable.js" type="text/javascript"></script>
    <script src="jscript/infrastructure_management.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common blue_steel title right top">
      <span class="common blue_steel title right top"><?php echo($item_group['name']); ?></span>
    </div>
    <div class="common blue_steel content with_title right top">
      <table class="object_list sortable" id="fileList" width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <th sortable="true" class="sortheader" onMouseDown="javascript:infrastructure_management_header_mouse_down(this);" onMouseOut="javascript:infrastructure_management_header_mouse_up(this);" onMouseUp="javascript:infrastructure_management_header_mouse_up(this);">
            &nbsp;
          </th>
          <th sortable="true" class="sortheader" onMouseDown="javascript:infrastructure_management_header_mouse_down(this);" onMouseOut="javascript:infrastructure_management_header_mouse_up(this);" onMouseUp="javascript:infrastructure_management_header_mouse_up(this);">
            Name
          </th>
          <th sortable="true" class="sortheader" onMouseDown="javascript:infrastructure_management_header_mouse_down(this);" onMouseOut="javascript:infrastructure_management_header_mouse_up(this);" onMouseUp="javascript:infrastructure_management_header_mouse_up(this);">
            IP Address
          </th>
          <th sortable="true" class="sortheader" onMouseDown="javascript:infrastructure_management_header_mouse_down(this);" onMouseOut="javascript:infrastructure_management_header_mouse_up(this);" onMouseUp="javascript:infrastructure_management_header_mouse_up(this);">
            OS
          </th>
          <th sortable="true" class="sortheader" onMouseDown="javascript:infrastructure_management_header_mouse_down(this);" onMouseOut="javascript:infrastructure_management_header_mouse_up(this);" onMouseUp="javascript:infrastructure_management_header_mouse_up(this);">
            Facility
          </th>
        </tr>

<?php

  $i = 0;
  foreach($items as $item) {
    $i++;

?>
        <tr id="TR<?php echo($i); ?>" class="object_list selected" onClick="javascript:infrastructure_management_object_click('<?php echo($subtype); ?>', <?php echo($item['id']); ?>, this);" onDblClick="javascript:infrastructure_management_object_dbl_click('<?php echo($subtype); ?>', <?php echo($item['id']); ?>);">
          <td>
            <img src="/common/images/<?php echo($subtype); ?>ico.png" style="height:18px; width:18px;" />
          </td>
          <td>
            <?php echo($item['name']); ?>

          </td>
          <td>
            <?php echo($item['primary_ip']); ?>

          </td>
          <td>
            <?php echo($item['os_version']); ?>

          </td>
          <td>
            <?php echo($item['facility']); ?>

          </td>
        </tr>
<?php

  }

?>
    </table>
  </body>
</html>
