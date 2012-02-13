<?php

  include ("../common/include/header.inc");

  $type = $common->get_query_string($_GET, "type");
  $id = $common->get_query_string($_GET, "id");

  switch ($type) {
    case "server_group":
      $item_group = $database->get_item_group_name("server", $id);
      $items_in_group = $database->get_items_in_item_group("server", $id);
      $items = $database->get_items("server");
      $subtype = "server";
      break;
    case "application_group":
      $item_group = $database->get_item_group_name("application", $id);
      $items_in_group = $database->get_items_in_item_group("application", $id);
      $items = $database->get_items("application");
      $subtype = "application";
      break;
    case "database_group":
      $item_group = $database->get_item_group_name("database", $id);
      $items_in_group = $database->get_items_in_item_group("database", $id);
      $items = $database->get_items("database");
      $subtype = "database";
      break;
    case "network_group":
      $item_group = $database->get_item_group_name("network", $id);
      $items_in_group = $database->get_items_in_item_group("network", $id);
      $items = $database->get_items("network");
      $subtype = "network";
      break;

  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Infrastructure Management - Add Item to <?php echo ($item_group['name']); ?>
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/infrastructure_management.css" type="text/css" />
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="jscript/infrastructure_management.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel item_list">
      <div class="common title blue_steel">
        <span class="common title blue_steel"><?php echo($item_group['name']); ?></span>
      </div>
      <div class="common content blue_steel item_list with_title">
        <select class="infrastructure_management available_items" multiple id="available_items">
<?php


  foreach($items as $row) if(! in_array($row, $items_in_group)) $available_items[] = $row;
  foreach ($available_items as $item) {

?>
          <option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option>
<?php

  }

?>
        </select>
        <input class="infrastructure_management move_item" type="image" onclick="infrastructure_management_move_item();" src="/common/images/forwardico.png" />
        <input class="infrastructure_management remove_item" type="image" onclick="infrastructure_management_remove_item();" src="/common/images/backico.png" />
        <select class="infrastructure_management items_in_group" multiple id="items_in_group">
<?php


  foreach ($items_in_group as $item) {

?>
          <option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option>
<?php

  }

?>
        </select>
      </div>
    </div>
    <div style="position: absolute; left: 5px; top: 310px; right: 0px; height: 24px;">
      <input type="button" value="OK" onclick="infrastructure_management_add_item_to_item_group2('<?php echo $subtype; ?>', '<?php echo $id; ?>');" />
      <input type="button" value="Cancel" onclick="window.close();" />
    </div>
  </body>
</html>
