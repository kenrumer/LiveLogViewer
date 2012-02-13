<?php

  require_once ("../common/include/header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $server_id = $common->get_query_string($_GET, 'server_id');
  $server = $database->get_server($server_id);
  $path = $common->get_query_string($_GET, 'path');

  if (!isset($_SESSION['compare_items'])) {
    $_SESSION['compare_items'] = array();
  }

  $found = FALSE;
  foreach ($_SESSION['compare_items'] as $pos) {
    if (($pos['type'] == $type) && ($pos['server'] == $server['fqdn']) && ($pos['path'] == $path)) {
      $found = TRUE;
      break;
    }
  }

  if (!$found) {
    $pos = count($_SESSION['compare_items']);

    $_SESSION['compare_items'][$pos] = array();
    $_SESSION['compare_items'][$pos]['type'] = $type;
    $_SESSION['compare_items'][$pos]['server'] = $server['fqdn'];
    $_SESSION['compare_items'][$pos]['path'] = $path;

    setcookie("compare_items[".$pos."][type]", $type, time() + 3600);
    setcookie("compare_items[".$pos."][server]", $server['fqdn'], time() + 3600);
    setcookie("compare_items[".$pos."][path]", $path, time() + 3600);
    foreach ($_SESSION['compare_items'] as $key => $row) {
      $arr_type[$key] = $row['type'];
      $arr_server[$key] = $row['server'];
      $arr_path[$key] = $row['path'];
    }
    array_multisort($arr_type, $arr_server, $arr_path, $_SESSION['compare_items']);
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - File Explorer - Compare Items View
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/sorttable.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/compare_items.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/sorttable.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="jscript/compare_items.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="compare_items blue_steel panel top">
      <table class="sortable" id="fileList" width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <th class="sortheader blue_steel">&nbsp;</th>
          <th sortable="true" class="sortheader blue_steel">type</th>
          <th sortable="true" class="sortheader blue_steel">server</th>
          <th sortable="true" class="sortheader blue_steel">path</th>
          <th class="sortheader blue_steel">&nbsp;</th>
        </tr>
<?php

  foreach ($_SESSION['compare_items'] as $pos => $row) {

?>
        <tr id="row<?php echo($pos); ?>">
          <td>
            <input type="checkbox" name="compare_item" value="<?php echo($pos); ?>" onclick="javascript:compare_items_toggle_item(this, '<?php echo($row['type']); ?>', '<?php echo($row['server']); ?>', '<?php echo($row['path']); ?>');" />
          </td>
          <td class="compare_items type">
            <?php echo($row['type']); ?>

          </td>
          <td class="compare_items server">
            <?php echo($row['server']); ?>

          </td>
          <td class="compare_items path">
            <?php echo($row['path']); ?>

          </td>
          <td class="compare_items remove">
            <a href="#" onclick="javascript:compare_items_remove_item('<?php echo ($pos); ?>');">remove</a>
          </td>
        </tr>
<?php

  }

?>
      </table>
    </div>
    <div class="compare_items panel bottom">
      <input type="button" onclick="javascript:compare_items_clear_selections();" value="Clear Selections">
      <input type="button" onclick="javascript:compare_items_remove_all();" value="Remove All">
      <input type="button" onclick="javascript:compare_items_compare_items();" value="Compare Items">
      <div class="compare_items message_area" id="compare_items_message_area">
        Selected items must be of similar type!!!
      </div>
    </div>
  </body>
</html>
