<?php

  require_once ("../common/include/header.inc");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - File Management
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="css/file_management.css" type="text/css" />
    <script src="jscript/file_management.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common blue_steel background">
      <div class="common blue_steel panel whole_page">
        <div class="file_management remove_entry">
          <input type="checkbox" name="r" id="remove_entry_checkbox" onclick="javascript:file_management_toggle_add_entry();" />Remove entry?<br />
          <font color="red">file name(entry name if none specified): </font><input class="file_management textbox2" type="text" name="file_name" /><br />
        </div>
        <div class="file_explorer add_entry" id="add_entry">
          <input type="checkbox" name="w" />Use entry name<input class="file_management textbox2" type="text" name="entry_name" /><br />
          <input type="checkbox" name="o" />Set owner <input class="file_management textbox2" type="text" name="owner" /><br />
          <input type="checkbox" name="g" />Set group <input class="file_management textbox2" type="text" name="group" /><br />
          <input type="checkbox" name="m" />Set mode <input class="file_management textbox2" type="text" name="mode" /><br />
          <div class="file_management rotate_options">
            Rotate Options<br />
            <input class="file_management indent1" type="checkbox" name="t" />Rename template (see man logadm for $word options)<input class="file_management textbox3" type="text" name="template" /><br />
            <input type="checkbox" name="M" />Replace rename command (replaces "mv $file $nfile")<input class="file_management textbox3" type="text" name="rename_cmd" /><br />
            <input type="checkbox" name="R" />Process renamed file command ($file is the filename)<input class="file_management textbox3" type="text" name="process_cmd" /><br />
            <input type="checkbox" name="b" />pre-rotate script: <input class="file_management textbox3" type="text" name="pre_rotate" /><br />
            <div class="file_management rotate_on_size">
              <input type="checkbox" name="s" onclick="javascript:file_management_toggle_rotate_size();" id="rotate_on_size" />Rotate on size<br />
              <div class="file_management rotate_size" id="rotate_size">
                <input type="text" name="rotate_size" /><br />
                <input type="radio" name="rotate_size_type" value="b" checked />bytes<br />
                <input type="radio" name="rotate_size_type" value="k" />kilobytes<br />
                <input type="radio" name="rotate_size_type" value="m" />megabytes<br />
                <input type="radio" name="rotate_size_type" value="g" />gigabytes<br />
              </div>
            </div>
            <div class="file_management rotate_on_period">
              <input type="checkbox" name="p" onclick="javascript:file_management_toggle_rotate_period();" id="rotate_on_period" />Rotate on period<br />
              <div class="file_management rotate_period" id="rotate_period">
                <input type="text" name="rotate_period" /><br />
                <input type="radio" name="rotate_period_type" value="now" checked />Now<br />
                <input type="radio" name="rotate_period_type" value="h" />Hours<br />
                <input type="radio" name="rotate_period_type" value="d" />Days<br />
                <input type="radio" name="rotate_period_type" value="w" />Weeks<br />
                <input type="radio" name="rotate_period_type" value="m" />Months<br />
                <input type="radio" name="rotate_period_type" value="y" />Years<br />
              </div>
            </div>
          </div>
          <div class="file_management expire_options">
            Expire Options<br />
            <input type="checkbox" name="T" />Expire pattern (defaults to rename template)<input class="file_management textbox3" type="text" name="pattern" /><br />
            <input type="checkbox" name="E" />Replace expire command (replaces "rm $file")<input class="file_management textbox3" type="text" name="expire_cmd" /><br />
            <div class="file_management expire_on_size">
              <input type="checkbox" name="S" onclick="javascript:file_management_toggle_expire_size();" id="expire_on_size" />Expire on size<br />
              <div class="file_management expire_size"  id="expire_size">
                <input type="text" name="expire_size" /><br />
                <input type="radio" name="expire_size_type" value="b" />bytes<br />
                <input type="radio" name="expire_size_type" value="k" />kilobytes<br />
                <input type="radio" name="expire_size_type" value="m" />megabytes<br />
                <input type="radio" name="expire_size_type" value="g" />gigabytes<br />
              </div>
            </div>
            <div class="file_management expire_on_count">
              <input type="checkbox" name="C" onclick="javascript:file_management_toggle_expire_count();" id="expire_on_count" />Expire count<br />
              <div class="file_management expire_count" id="expire_count">
                <input type="text" name="expire_count" /><br />
              </div>
            </div>
            <input type="checkbox" name="z" />Compress all but...  <input class="file_management textbox3" type="text" name="compress_count" /><br />
          <input type="checkbox" name="e" />Send errors to: <input class="file_management textbox3" type="text" name="mail_addr">
        </div>
      </div>
    </div>
  </body>
</html>
