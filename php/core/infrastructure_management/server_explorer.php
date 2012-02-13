<?php

  include ("../common/include/header.inc");

  $server = $common->get_query_string($_GET, 'server');

?><!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <title>
      ASC - Infrastructure Management - <?php echo($server); ?>
    </title>
  </head>
  <frameset id="outerFrame" cols="177,*" border="5" bordercolor="#C6DBFF" frameborder="1">
    <frame src="views_frame.php" name="viewsFrame" id="viewsFrame" frameborder="0" />
    <frame src="summary_frame.php" name="outputFrame" id="outputFrame" frameborder="0" />
  </frameset>
</html>
