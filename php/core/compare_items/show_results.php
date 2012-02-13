<?php

  @require_once ("../common/include/header.inc");

  $type = $common->get_query_string($_GET, 'type');
  $server1 = $common->get_query_string($_GET, 'server1');
  $server2 = $common->get_query_string($_GET, 'server2');
  $path1 = $common->get_query_string($_GET, 'path1');
  $path2 = $common->get_query_string($_GET, 'path2');

  if ($type == "file") {

    if (isset($_SERVER['HTTPS'])) {
      @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server1.'/get_file_info.php?path='.urlencode($path1));
    } else {
      @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server1.'/get_file_info.php?path='.urlencode($path1));
    }

    $perms1 = $perms;
    $attribs1 = $attribs;
    $file_size1 = $file_size;
    $line_count1 = $line_count;

    if (isset($_SERVER['HTTPS'])) {
      @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server2.'/get_file_info.php?path='.urlencode($path2));
    } else {
      @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server2.'/get_file_info.php?path='.urlencode($path2));
    }

    $perms2 = $perms;
    $attribs2 = $attribs;
    $file_size2 = $file_size;
    $line_count2 = $line_count;

    $file_info = "<table class=\"compare_items show_results\"><tr><th class=\"compare_items show_results file1\">".$server1."</th><th class=\"compare_items show_results file1\">".$path1."</th><th class=\"compare_items show_results file1\">".$attribs1['nlink']."</th><th class=\"compare_items show_results file1\">";
    if ($attribs1['uid'] != 0) {
      $file_info = $file_info.$attribs1['uid']."</th><th class=\"compare_items show_results file1\">".$attribs1['gid']."</th><th class=\"compare_items show_results file1\">";
    }
    $file_info = $file_info.$common->byte_convert($attribs1['size'])."</th><th class=\"compare_items show_results file1\">".strftime("%m/%d/%Y %H:%M:%S", $attribs1['mtime'])."</th><th class=\"compare_items show_results file1\">".basename($path1)."</th></tr><tr border=1><th class=\"compare_items show_results file2\">".$server2."</th><th class=\"compare_items show_results file2\">".$path2."</th><th class=\"compare_items show_results file2\">".$attribs2['nlink']."</th><th class=\"compare_items show_results file2\">";
    if ($attribs2['uid'] != 0) {
      $file_info = $file_info.$attribs2['uid']."</th><th class=\"compare_items show_results file2\">".$attribs2['gid']."</th><th class=\"compare_items show_results file2\">";
    }
    $file_info = $file_info.$common->byte_convert($attribs2['size'])."</th><th class=\"compare_items show_results file2\">".strftime("%m/%d/%Y %H:%M:%S", $attribs2['mtime'])."</th><th class=\"compare_items show_results file2\">".basename($path2)."</th></tr></table>";

  } else {

    if (isset($_SERVER['HTTPS'])) {
      @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server1."/get_directory_contents.php?paths=".urlencode($path1));
    } else {
      @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server1."/get_directory_contents.php?paths=".urlencode($path1));
    }
    $dir_content1 = $_DIR_CONTENT[$server1][$path1];
    if (isset($_SERVER['HTTPS'])) {
      @require("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server2."/get_directory_contents.php?paths=".urlencode($path2));
    } else {
      @require("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server2."/get_directory_contents.php?paths=".urlencode($path2));
    }
    $dir_content2 = $_DIR_CONTENT[$server2][$path2];

    $file_info = "<table class=\"compare_items show_results\"><tr><th class=\"compare_items show_results file1\">".$server1."</th><th class=\"compare_items show_results file1\">".$path1."</th></tr><tr><th class=\"compare_items show_results file2\">".$server2."</th><th class=\"compare_items show_results file2\">".$path2."</th></tr></table>";

  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Compare Items - <?php echo($server1.":".$path1." | ".$server2.":".$path2); ?>
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <script language="javascript">
      var file_info='<?php echo($file_info); ?>';
      var strPath1="<?php echo($path1); ?>";
      var strPath2="<?php echo($path2); ?>";
      var strServer1 = "<?php echo($server1); ?>";
      var strServer2 = "<?php echo($server2); ?>";
      var strFileName = "<?php echo($server1."_".basename($path1)."VS".$server2."_".basename($path2)); ?>";
    </script>
    <link rel="stylesheet" href="css/compare_items.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
    <script src="jscript/compare_items.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="compare_items show_results panel top">
      <a class="compare_items tool_anchor" href="javascript:compare_items_toggle_save_as();"><img class="compare_items tool_image" id="save_as_button" src="/common/images/save_as.png" alt="save as" title="save as" /></a><a class="compare_items tool_anchor" href="javascript:compare_items_toggle_email();"><img class="compare_items tool_image" id="email_button" src="/common/images/email.png" alt="email" title="email" /></a><a class="compare_items tool_anchor" href="javascript:compare_items_refresh();""><img class="compare_items tool_image" id="refresh_button" src="/common/images/refresh.png" /></a><a class="compare_items tool_anchor" href="javascript:compare_items_toggle_wrap();"><img class="compare_items tool_image" id="word_wrap_button" src="/common/images/word_wrap.png" alt="word wrap" title="word wrap" /></a><a class="compare_items tool_anchor" href="javascript:compare_items_toggle_info();"><img class="compare_items tool_image" id="info_button" src="/common/images/info_down.png" /></a><a class="compare_items tool_anchor" href="javascript:compare_items_toggle_find();"><img class="compare_items tool_image" id="find_button" src="/common/images/find.png" alt="find text" title="find text" /></a>
    </div>
    <div class="compare_items show_results panel content" id="content">
<?php

  if ($type == "file") {
    if (($file_size1 > $session->get("file_size_limit", "file_explorer")) || ($file_size2 > $session->get("file_size_limit", "file_explorer"))) {
      if ($file_size1 > $file_size2) {
        echo ("<script language=\"javascript\">alert(\"file size (".path1.") ".$common->byte_convert($file_size1)." is > ".$common->byte_convert($session->get("file_size_limit", "file_explorer"))." limit, truncating first ".$common->byte_convert($file_size1 - $session->get("file_size_limit", "file_explorer"))."\");</script>");
      } else {
        echo ("<script language=\"javascript\">alert(\"file size (".path2.") ".$common->byte_convert($file_size2)." is > ".$common->byte_convert($session->get("file_size_limit", "file_explorer"))." limit, truncating first ".$common->byte_convert($file_size2 - $session->get("file_size_limit", "file_explorer"))."\");</script>");
      }
    }

?>
<pre>
<?php

    require_once ("Text/Diff.php");
    require_once ("Text/Diff/Renderer.php");
    require_once ("Text/Diff/Renderer/inline.php");

    if (isset($_SERVER['HTTPS'])) {
      $lines1 = file("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server1.'/get_file.php?path='.urlencode($path1).'&limit='.$session->get("file_size_limit", "file_explorer"));
    } else {
      $lines1 = file("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server1.'/get_file.php?path='.urlencode($path1).'&limit='.$session->get("file_size_limit", "file_explorer"));
    }
    if (isset($_SERVER['HTTPS'])) {
      $lines2 = file("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server2.'/get_file.php?path='.urlencode($path2).'&limit='.$session->get("file_size_limit", "file_explorer"));
    } else {
      $lines2 = file("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server.'/'.$server2.'/get_file.php?path='.urlencode($path2).'&limit='.$session->get("file_size_limit", "file_explorer"));
    }
    $diff = new Text_Diff('auto', array($lines1, $lines2));
    $renderer = new Text_Diff_Renderer_inline();
    echo html_entity_decode($renderer->render($diff));

?>
</pre>
<?php

  } else {

    $ins_array = array();
    $del_array = array();

    $ins_array['directories'] = array();
    $del_array['directories'] = array();
    if (array_key_exists("directories", $dir_content1) || array_key_exists("directories", $dir_content2)) {
      if (array_key_exists("directories", $dir_content1)) {
        if (array_key_exists("directories", $dir_content2)) {
          foreach($dir_content1['directories'] as $key => $value) {
            if (!array_key_exists($key, $dir_content2['directories'])) {
              $ins_array['directories'][] = $key;
            }
          }
        } else {
          foreach($dir_content1['directories'] as $key => $value) {
            $ins_array['directories'][] = $key;
          }
        }
      }
      if (array_key_exists("directories", $dir_content2)) {
        if (array_key_exists("directories", $dir_content1)) {
          foreach($dir_content2['directories'] as $key => $value) {
            if (!array_key_exists($key, $dir_content1['directories'])) {
              $del_array['directories'][] = $key;
            }
          }
        } else {
          foreach($dir_content2['directories'] as $key => $value) {
            $del_array['directories'][] = $key;
          }
        }
      }
    }

    $ins_array['files'] = array();
    $del_array['files'] = array();
    $diff_size_array = array();
    if (array_key_exists("files", $dir_content1) || array_key_exists("files", $dir_content2)) {
      if (array_key_exists("files", $dir_content1)) {
        if (array_key_exists("files", $dir_content2)) {
          foreach($dir_content1['files'] as $key => $value) {
            if (!array_key_exists($key, $dir_content2['files'])) {
              $ins_array['files'][] = $key;
            } else {
              if ($value[7] != $dir_content2['files'][$key][7]) {
                $diff_size_array[] = $key;
              }
            }
          }
        } else {
          foreach($dir_content1['files'] as $key => $value) {
            $ins_array['files'][] = $key;
          }
        }
      }
      if (array_key_exists("files", $dir_content2)) {
        if (array_key_exists("files", $dir_content1)) {
          foreach($dir_content2['files'] as $key => $value) {
            if (!array_key_exists($key, $dir_content1['files'])) {
              $del_array['files'][] = $key;
            }
          }
        } else {
          foreach($dir_content2['files'] as $key => $value) {
            $del_array['files'][] = $key;
          }
        }
      }
    }

    $ins_count = count($ins_array['directories']);
    $del_count = count($del_array['directories']);

?>
<?php

    for ($i = 0; $i < $ins_count || $i < $del_count; $i++) {

?>
      <div class="compare_items show_results dir_output">
        <?php if (isset($ins_array['directories'][$i])) echo("<div class=\"compare_items show_results left output\"><ins>./".$ins_array['directories'][$i]."</ins></div>"); ?>
        <?php if (isset($del_array['directories'][$i])) echo("<div class=\"compare_items show_results right output\"><del>./".$del_array['directories'][$i]."</del></div>"); ?>
      </div>
<?php

    }
    $ins_count = count($ins_array['files']);
    $del_count = count($del_array['files']);

?>
<?php

    for ($i = 0; $i < $ins_count || $i < $del_count; $i++) {

?>
      <div class="compare_items show_results file_output">
        <?php if (isset($ins_array['files'][$i])) echo("<div class=\"compare_items show_results left output\"><ins>".$ins_array['files'][$i]."</ins></div>"); ?><?php if (isset($del_array['files'][$i])) echo("<div class=\"compare_items show_results right output\"><del>".$del_array['files'][$i]."</del></div>\n"); ?>
      </div>
<?php

    }
?>
<?php

    foreach ($diff_size_array as $key) {

?>
      <div class="compare_items show_results size_output">
        <?php echo ("<div>".$key." file sizes are different</div>"); ?>
      </div>
<?php

    }

?>
<?php

  }

?>
    </div>
    <div class="compare_items show_results panel bottom" id="bottom">
      &nbsp;<?php echo($file_info); ?>
    </div>
  </body>
</html>
