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
      ASC - Path Administration - Update Path
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="css/path_administration.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="/common/jscript/css.js" type="text/javascript"></script>
    <script src="jscript/path_administration.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel path_administration">
      <div class="common title blue_steel">
        <span class="common title blue_steel">Path Administration - Update Path</span>
      </div>
      <div class="common content blue_steel with_title">
        <div class="path_administration outer_panel">
          <label for="path" class="path_administration path">Path</label>
          <div class="path_administration path"><input type="text" class="path_administration path" id="name" name="name" value="" /></div>
          <div class="path_administration is_root"><input type="checkbox" class="path_administration is_root" id="is_root" name="is_root" checked /></div>
          <label for="is_root" class="path_administration is_root">Is Root</label>
          <div class="path_administration is_directory"><input type="checkbox" class="path_administration is_directory" id="is_directory" name="is_directory" checked /></div>
          <label for="is_directory" class="path_administration is_directory">Is Directory</label>
          <div class="path_administration status_panel" id="status_panel"></div>
          <div class="path_administration ok_button"><input class="path_administration ok_button" type="button" value="OK" onclick="path_administration_new_path();"></div>
          <div class="path_administration cancel_button"><input class="path_administration cancel_button" type="button" value="cancel" onclick="path_administration_cancel_edit_path();"></div>
        </div>
      </div>
    </div>
  </body>
</html>
