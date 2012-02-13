<?php

  include ("../common/include/header.inc");

  $server_id = $common->get_query_string($_GET, "server_id");

  $server = $database->get_item("server", $server_id);

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Server Administration - Update Server
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="css/server_administration.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/css.js" type="text/javascript"></script>
    <script src="jscript/server_administration.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel server_administration">
      <div class="common title blue_steel">
        <span class="common title blue_steel">Server Administration - Update Server</span>
      </div>
      <div class="common content blue_steel with_title">
        <div class="server_administration outer_panel">
          <label for="name" class="server_administration name">Name</label>
          <div class="server_administration name"><input class="server_administration name" id="name" name="name" value="<?php echo $server['name']; ?>" /></div>
          <label for="hostname" class="server_administration hostname">Hostname</label>
          <div class="server_administration hostname"><input class="server_administration hostname" id="hostname" name="hostname" value="<?php echo $server['hostname']; ?>" /></div>
          <label for="fqdn" class="server_administration fqdn">FQDN</label>
          <div class="server_administration fqdn"><input readonly class="server_administration fqdn readonly" id="fqdn" name="fqdn" value="<?php echo $server['fqdn']; ?>" /></div>
          <label for="primary_ip" class="server_administration primary_ip">IP Address</label>
          <div class="server_administration primary_ip"><input readonly class="server_administration primary_ip readonly" id="primary_ip" name="primary_ip" value="<?php echo $server['primary_ip']; ?>" /></div>
          <label for="os" class="server_administration os">OS</label>
          <div class="server_administration os"><input class="server_administration os" id="os" name="os" value="<?php echo $server['os']; ?>" /></div>
          <label for="facility" class="server_administration facility">Facility</label>
          <div class="server_administration facility"><input class="server_administration facility" id="facility" name="facility" value="<?php echo $server['facility']; ?>" /></div>
          <label for="service_tag" class="server_administration service_tag">Service Tag</label>
          <div class="server_administration service_tag"><input class="server_administration service_tag" id="service_tag" name="service_tag" value="<?php echo $server['service_tag']; ?>" /></div>
          <label for="end_of_service_life" class="server_administration end_of_service_life">End of service life</label>
          <div class="server_administration end_of_service_life"><input class="server_administration end_of_service_life" id="end_of_service_life" name="end_of_service_life" value="<?php echo $server['end_of_service_life']; ?>" /></div>
          <div class="server_administration paths_panel">
            <table style="width:100%;">
              <tr>
                <th>
                  path
                </th>
                <th>
                  &nbsp;
                </th>
              </tr>
<?php

  $paths = $database->get_allowed_paths_for_server($server_id);
  foreach ($paths as $path) {

?>
              <tr>
                <td>
                  <?php echo ($path['name']); ?>
                </td>
                <td style="text-align:right;">
                  <a href="#" onclick="javascript:server_administration_remove_path(<?php echo ($server_id); ?>, <?php echo($path['id']); ?>, this.parent)";>remove</a>
                </td>
              </tr>
<?php

  }

?>
            </table>
          </div>
          <select class="server_administration paths_list" name="paths_list" id="paths_list" />
<?php

  $paths = $database->get_paths();
  foreach ($paths as $path) {

?>
            <option value="<?php echo ($path['id']); ?>">
              <?php echo ($path['name']); ?>
            </option>
<?php

  }

?>
          </select>
          <input class="server_administration paths_add" type="button" value="Add" onclick="javascript:server_administration_add_path(<?php echo ($server_id); ?>);" />
          <div class="server_administration server_groups_panel">
            <table style="width: 100%;">
              <tr>
                <th>
                  server group
                </th>
                <th>
                  description
                </th>
                <th>
                  &nbsp;
                </th>
              </tr>
<?php

  $server_groups = $database->get_server_groups_for_server($server_id);
  foreach ($server_groups as $server_group) {
    $server_group = $database->get_server_group($server_group['id']);

?>
              <tr>
                <td>
                  <?php echo ($server_group['name']); ?>
                </td>
                <td>
                  <?php echo ($server_group['description']); ?>
                </td>
                <td style="text-align:right;">
                  <a href="#" onclick="javascript:server_administration_remove_server_group(<?php echo ($server_id); ?>, <?php echo($server_group['id']); ?>, this.parent.parent);">remove</a>
                </td>
              </tr>
<?php

  }

?>
            </table>
          </div>
          <select class="server_administration server_groups_list" name="server_groups_list" id="server_groups_list" />
<?php

  $server_groups = $database->get_server_groups();
  foreach ($server_groups as $server_group) {

?>
            <option value="<?php echo ($server_group['id']); ?>">
              <?php echo ($server_group['name'].":".$server_group['description']); ?>
            </option>
<?php

  }

?>
          </select>
          <input class="server_administration server_groups_add" type="button" value="Add" onclick="javascript:server_administration_add_server_group(<?php echo ($server_id); ?>);" />
          <div class="server_administration status_panel" id="status_panel"></div>
        </div>
        <div class="server_administration ok_button"><input class="server_administration ok_button" type="button" value="OK" onclick="server_administration_update_server(<?php echo $server_id; ?>);"></div>
        <div class="server_administration cancel_button"><input class="server_administration cancel_button" type="button" value="cancel" onclick="server_administration_cancel_edit_server();"></div>
      </div>
    </div>
  </body>
</html>
