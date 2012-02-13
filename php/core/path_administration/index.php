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
      ASC - Path Administration
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
        <span class="common title blue_steel">Path Administration</span>
      </div>
      <div class="common content blue_steel with_title">
        <select class="path_administration path_list" id="path_list" name="path_name" multiple>
<?php

  $paths = $database->get_items("path");
  foreach ($paths as $path) {

?>
          <option value="<?php echo $path['id']; ?>"><?php echo $path['name']; ?></option>
<?php

  }

?>
        </select>
        <input class="path_administration edit_button" type="button" value="Edit >>" onclick="path_administration_edit_path();" />
        <input class="path_administration remove_button" type="button" value="Remove" onclick="path_administration_remove_path();" />
        <input class="path_administration add_button" type="button" value="Add >>" onclick="path_administration_add_path();" />
        <div id="status_panel"></div>
      </div>
    </div>
  </body>
</html>
