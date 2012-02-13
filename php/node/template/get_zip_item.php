<?php

  require_once("../include/common.inc");
  require_once("../include/explorer.inc");

  $common = new common();
  $explorer = new explorer();

  $path = $common->get_query_string($_GET, 'path');

  set_time_limit(0);

  $file_name = tempnam("/app/asc", "asc");
  unlink($file_name);
  $file_name = $file_name.".zip";
  $zip_file = new ZipArchive;
  $zip_file->open($file_name, ZIPARCHIVE::CREATE);
  $explorer->create_zip($path, $zip_file, "");
  $zip_file->close();
  ob_clean();
  flush();
  header("Content-Length: " . filesize($file_name));
  $fh = @fopen($file_name, "rb");
  if ($fh !== FALSE) {
    while (!feof($fh)) {
      echo fread ($fh, 1024000);
    }
  }
  fclose($fh);
  unlink($file_name);

?>
