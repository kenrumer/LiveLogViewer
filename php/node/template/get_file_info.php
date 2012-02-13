<?php

  require_once("../include/common.inc");

  $common = new common();

  $path = $common->get_query_string($_GET, 'path');

  echo ("<?php\n");

  $perms = substr(decoct(fileperms($path)), 3);
  echo ("\$perms = \"".$perms."\"".';'."\n");
  $attribs = stat($path);
  echo ("\$attribs = ");
  var_export($attribs);
  echo (';'."\n");
  $file_size = $attribs['size'];
  echo ("\$file_size = \"".$file_size."\"".';'."\n");
  $basename = basename($path);
  echo ("\$basename = \"".$basename."\"".';'."\n");

  echo ('?>');
?>
