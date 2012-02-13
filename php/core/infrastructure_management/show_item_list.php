<?php

  include ("../common/include/header.inc");
  require_once ("../common/HTML/Table.php");

  $type = $common->get_query_string($_GET, "type");
  $id = $common->get_query_string($_GET, "id");

  switch ($type) {
    case "my_server_group":
    case "server_group":
      $item_group = $database->get_item_group_name("server", $id);
      $item_header = $database->get_item_fields("server");
      $items = $database->get_items_in_item_group("server", $id);
      $subtype = "server";
      break;
    case "my_application_group":
    case "application_group":
      $item_group = $database->get_item_group_name("application", $id);
      $item_header = $database->get_item_fields("application");
      $items = $database->get_items_in_item_group("application", $id);
      $subtype = "application";
      break;
    case "my_database_group":
    case "database_group":
      $item_group = $database->get_item_group_name("database", $id);
      $item_header = $database->get_item_fields("database");
      $items = $database->get_items_in_item_group("database", $id);
      $subtype = "database";
      break;
    case "my_network_group":
    case "network_group":
      $item_group = $database->get_item_group_name("network", $id);
      $item_header = $database->get_item_fields("network");
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
    <div class="common panel blue_steel item_list">
      <div class="common title blue_steel">
        <span class="common title blue_steel"><?php echo($item_group['name']); ?></span>
      </div>
      <div class="common content blue_steel item_list with_title">
<?php

  $attrs = array('class' => 'sortable', 'id' => '1table', 'name' => 'test');
  $table = new HTML_Table($attrs);
  $table->setAutoGrow(true);
  $head =& $table->getHeader();
  $body =& $table->getBody();

  $field_count = count($item_header);
  for ($i = 0; $i < $field_count; $i++) {
    $head->setHeaderContents(0, $i, $item_header[$i]);
  }
  $row_count = count($items);
  for ($j = 0; $j < $row_count; $j++) {
    $attrs = array('onclick' => 'infrastructure_management_show_item_details(this);', 'oncontextmenu' => 'return context_menu_show_context_menu(this);', 'item_id' => $items[$j][0], 'item_type' => $subtype, 'class' => 'object_list', 'id' => md5(uniqid(rand(), true)));
    $body->setRowAttributes($j, $attrs, TRUE);
    for ($i = 0; $i < $field_count; $i++) {
      $body->setCellContents($j, $i, $items[$j][$i]);
    }
  }

  echo $table->toHtml();

?>
      </div>
    </div>
    <div class="common panel blue_steel item_details_frame">
      <div class="common content blue_steel">
        <iframe class="infrastructure_management details_frame" id="details_frame" name="details_frame" src="/common/blank.html"></iframe>
      </div>
    </div>
    <div class="show_item_list_panel server context_menu" id="server_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_show_item_details');" title="Show Server Details"><b>Show Server Details</b></a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_open_item');" title="View filesystem on this server group">File Viewer</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('compare_items_add_item');" title="Compare this server">Compare Server</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_add_server_to_group');" title="Add To Group..."><img class="context_menu icon" src="/common/images/add_serverico.png" title="Add To Group" />Add To Group...</a>
      <a class="context_menu" href="#" onclick="context_menu_item_click('infrastructure_management_remove_server_from_group');" title="Remove From Group..."><img class="context_menu icon" src="/common/images/remove_serverico.png" title="Remove From Group" />Remove From Group...</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" title="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('infrastructure_management_properties');" title="Display standard properties of the server group">Properties</a>
    </div>
  </body>
</html>
