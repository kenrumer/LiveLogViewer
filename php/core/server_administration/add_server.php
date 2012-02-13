<?php

  include ("../common/include/header.inc");

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
          <div class="server_administration name"><input type="text" class="server_administration name" id="name" name="name" value="" /></div>
          <label for="hostname" class="server_administration hostname">Hostname</label>
          <div class="server_administration hostname"><input type="text" class="server_administration hostname" id="hostname" name="hostname" value="" /></div>
          <label for="fqdn" class="server_administration fqdn">FQDN</label>
          <div class="server_administration fqdn"><input type="text" class="server_administration fqdn" id="fqdn" name="fqdn" value="" /></div>
          <label for="primary_ip" class="server_administration primary_ip">IP Address</label>
          <div class="server_administration primary_ip"><input type="text" class="server_administration primary_ip" id="primary_ip" name="primary_ip" value="" /></div>
          <label for="os" class="server_administration os">OS</label>
          <div class="server_administration os"><input type="text" class="server_administration os" id="os" name="os" value="" /></div>
          <label for="facility" class="server_administration facility">Facility</label>
          <div class="server_administration facility"><input type="text" class="server_administration facility" id="facility" name="facility" value="" /></div>
          <label for="service_tag" class="server_administration service_tag">Service Tag</label>
          <div class="server_administration service_tag"><input type="text" class="server_administration service_tag" id="service_tag" name="service_tag" value="" /></div>
          <label for="end_of_service_life" class="server_administration end_of_service_life">End of service life</label>
          <div class="server_administration end_of_service_life"><input type="text" class="server_administration end_of_service_life" id="end_of_service_life" name="end_of_service_life" value="" /></div>
          <div class="server_administration os_type_unix"><input type="radio" class="server_administration os_type_unix" id="os_type_unix" name="os_type" value="unix" /><label for="os_type_unix">*NIX</label></div>
          <div class="server_administration os_type_win"><input type="radio" class="server_administration os_type_win" id="os_type_win" name="os_type" value="win" /><label for="os_type_win">Windows</label></div>
          <div class="server_administration status_panel" id="status_panel"></div>
          <div class="server_administration ok_button"><input class="server_administration ok_button" type="button" value="OK" onclick="server_administration_new_server();"></div>
          <div class="server_administration cancel_button"><input class="server_administration cancel_button" type="button" value="cancel" onclick="server_administration_cancel_edit_server();"></div>
        </div>
      </div>
    </div>
  </body>
</html>
