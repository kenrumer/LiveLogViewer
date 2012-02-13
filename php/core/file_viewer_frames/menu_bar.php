<?php

  @require_once ("../common/include/header.inc");

  $tail = $common->get_query_string($_GET, 'tail', FALSE);
  if (!isset($tail)) {
    $tail = FALSE;
  }
  if ($tail == "false") {
    $tail = FALSE;
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Menu bar
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" />
    <link rel="stylesheet" href="css/file_viewer.css" />
    <script src="jscript/file_viewer.js"></script>
  </head>
  <body style="height: 100%;">
    <div class="file_viewer blue_steel panel top" id="top">
      <a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_save_as();"><img class="file_viewer tool_image" id="save_as_button" src="/common/images/save_as.png" alt="save as" title="save as" /></a><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_email();"><img class="file_viewer tool_image" id="email_button" src="/common/images/email.png" alt="email" title="email" /></a><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_refresh();""><img class="file_viewer tool_image" id="refresh_button" src="/common/images/refresh.png" /></a><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_wrap();"><img class="file_viewer tool_image" id="word_wrap_button" src="/common/images/word_wrap.png" alt="word wrap" title="word wrap" /></a><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_info();"><img class="file_viewer tool_image" id="info_button" src="/common/images/info_down.png" /></a><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_find();"><img class="file_viewer tool_image" id="find_button" src="/common/images/find.png" alt="find text" title="find text" /><a class="file_viewer tool_anchor" href="#" onclick="file_viewer_toggle_tail();"><img class="file_viewer tool_image" id="tail_button" src="/common/images/<?php if ($tail) { echo ("tail.png"); } else { echo ("tail_down.png"); } ?>" alt="toggle tail" title="toggle tail" /></a>
    </div>
  </body>
</html>
