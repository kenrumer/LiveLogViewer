<?php

  include("./include/im.inc");

  $server = getRequiredQueryString($_GET, 'server');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Infrastructure Management - Details Frame : <?php echo($server); ?>
    </title>
    <link rel="stylesheet" href="/im/css/title.css" type="text/css" />
    <link rel="stylesheet" href="/im/css/details_frame.css" type="text/css" />
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/im/css/ie6fix.css" type="text/css">
    <![endif]-->
    <script src="/im/jscript/details_frame.js" type="text/javascript"></script>
  </head>
  <body>
    <div id="outer">
      <div id="title_right_top">
        <span class="valign_middle_title"><?php echo($server); ?></span>
      </div>
      <div id="content">
      </div>
    </div>
  </body>
</html>
