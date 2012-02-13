<?php

  @require_once ("../common/include/header.inc");

  $path = $common->get_query_string($_GET, 'path');
  $server_id = $common->get_query_string($_GET, 'server_id');
  $tail = $common->get_query_string($_GET, 'tail', FALSE);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<html>
  <head>
    <title>
      ASC - File Viewer - <?php echo($server['name'].":".$path); ?>
    </title>
  </head>
  <frameset rows="45, *, 45">
    <frame src="/file_viewer_frames/menu_bar.php?tail=<?php echo $tail; ?>" id="menu_bar" name="menu_bar" />
    <frame src="/file_viewer_frames/output_frame.php?path=<?php echo $path; ?>&server_id=<?php echo $server_id; ?>&tail=<?php echo $tail; ?>" name="output_frame" id="output_frame" />
    <frame src="/file_viewer_frames/status_bar.php?path=<?php echo $path; ?>&server_id=<?php echo $server_id; ?>" name="status_bar" id="status_bar" />
  </frameset>

</html>
