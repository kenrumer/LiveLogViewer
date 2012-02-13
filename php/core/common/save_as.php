<?php

  require_once ("../common/include/common.inc");

  $common = new common();

  $filename = $common->get_post_string($_POST, "filename");
  $filedata = $common->get_post_string($_POST, "filedata");

  header('Content-Description: File Transfer');
  header('Pragma: public');
  header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Cache-Control: private', false);
  header('Content-Type: application/force-download');
  header('Content-Transfer-Encoding: binary');
  header("Content-Disposition: filename=".$filename);

  $filedata = html_entity_decode(urldecode($filedata));

  echo ($filedata);

?>
