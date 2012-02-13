<?php

  include ("../common/include/header.inc");

  $server_group_ids = $common->get_query_string($_GET, 'server_group_ids');
  $server_group_ids = explode(",", $server_group_ids);
  $server_group = $database->get_server_group($server_group_ids[0]);

  $indent = 1;

  $plus_indent = $indent * 13;
  $icon_indent = $plus_indent + 9;
  $indent = $indent + 1;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - <?php echo $server_group['name'] ?> - Server Group Explorer
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/context_menu.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <link rel="stylesheet" href="css/search_panel.css" type="text/css" />
    <link rel="stylesheet" href="css/server_group_explorer.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js" type="text/javascript"></script>
    <script src="jscript/server_group_explorer.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common panel blue_steel left_top" id="folder_panel_panel">
      <div class="common content blue_steel">
<?php

  if (count($server_group_ids) > 1) {
    foreach($server_group_ids as $server_group_id) {
      $server_group = $database->get_server_group($server_group_id);
      $server_group_display_name = $server_group['name'];
      $server_group_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $server_group['name']) . "_" . md5(uniqid(rand(), true));
      $server_group['name'] = urlencode($server_group['name']);

?>
        <div class="folder_panel nowrap" id="<?php echo($server_group_id); ?>" expanded="false" item_type="server_group" item_id="<?php echo($server_group['id']); ?>" item_name="<?php echo($server_group_display_name); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($server_group_id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/server_groupico.png" id="<?php echo($server_group_id); ?>image"></a>
          <a class="folder_panel server_group text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($server_group_display_name); ?></a>
        </div>
<?php

    }
  } else {
    $server_group = $database->get_server_group($server_group_ids[0]);
    $server_group_display_name = $server_group['name'];
    $server_group_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $server_group['name']) . "_" . md5(uniqid(rand(), true));
    $server_group['name'] = urlencode($server_group['name']);

?>
        <div class="folder_panel nowrap" id="<?php echo($server_group_id); ?>" expanded="true" item_type="server_group" item_id="<?php echo($server_group['id']); ?>" item_name="<?php echo($server_group_display_name); ?>" item_indent="1">
          <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/minusico.png" id="<?php echo($server_group_id); ?>expand" alt="+" /></a>
          <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/server_groupico.png" id="<?php echo($server_group_id); ?>image"></a>
          <a class="folder_panel server_group text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($server_group_display_name); ?></a><BR />
<?php

    $child_server_groups = $database->get_server_groups_in_server_group($server_group['id']);
    foreach($child_server_groups as $child_server_group) {
      //$child_server_group = $database->get_server_group($child_server_group_id);
      $child_server_group_display_name = $child_server_group['name'];
      $child_server_group['name'] = urlencode($child_server_group['name']);
      $child_server_group_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $child_server_group['name']) . "_" . md5(uniqid(rand(), true));
?>
          <div class="folder_panel nowrap" style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($child_server_group_id); ?>" expanded="false" item_type="server_group" item_id="<?php echo($child_server_group['id']); ?>" item_name=<?php echo($child_server_group_display_name); ?>" item_indent="<?php echo($indent); ?>">
            <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($child_server_group_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($child_server_group_id); ?>expand" alt="+" /></a>
            <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($child_server_group_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><img class="folder_panel icon" src="/common/images/server_groupico.png" id="<?php echo($child_server_group_id); ?>image"></a>
            <a class="folder_panel server_group text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($child_server_group_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($child_server_group_display_name); ?></a>
          </div>
<?php

    }
    $servers = $database->get_servers_in_server_group($server_group['id']);
    foreach($servers as $server) {
      $server_display_name = $server['name'];
      $server['name'] = urlencode($server['name']);
      $server_id = str_replace(array(" ", ".", "-", "/", ":", "'"), "", $server['name']) . "_" . md5(uniqid(rand(), true));

?>
          <div class="folder_panel nowrap" style="text-indent: <?php echo($plus_indent); ?>pt" id="<?php echo($server_id); ?>" expanded="false" item_type="server" item_id="<?php echo($server['id']); ?>" item_name=<?php echo($server_display_name); ?>" item_indent="<?php echo($indent); ?>">
            <a class="folder_panel" href="#" onclick="server_group_explorer_expand_item(this.parentNode);" id="<?php echo($server_id); ?>href1"><img class="folder_panel expand" src="/common/images/plusico.png" id="<?php echo($server_id); ?>expand" alt="+" /></a>
            <a class="folder_panel" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_id); ?>href2" oncontextmenu="return context_menu_show_context_menu(this.parentNode); ?>);"><img class="folder_panel icon" src="/common/images/serverico.png" id="<?php echo($server_id); ?>image"></a>
            <a class="folder_panel server text" href="#" onclick="server_group_explorer_open_item(this.parentNode);" id="<?php echo($server_id); ?>href3" oncontextmenu="return context_menu_show_context_menu(this.parentNode);"><?php echo($server_display_name); ?></a>
          </div>
<?php

    }

?>
        </div>
<?php

  }

?>
      </div>
    </div>
    <div class="common blue_steel panel left_bottom" id="search_panel_panel">
      <div class="common blue_steel content">
        <a class="search_panel toggle_bar" href="#" onclick="server_group_explorer_toggle_search();" title="Toggle Search">
          <div class="search_panel toggle_bar colapsed" id="search_panel_toggle_bar"></div>
        </a>
        <div class="search_panel toggle_area" id="search_panel_toggle_area">
          <div class="search_panel top_middle"></div>
          <div class="search_panel bottom_middle"></div>
          <div class="search_panel left" id="search_panel_left"></div>
          <div class="search_panel right" id="search_panel_right"></div>
          <div class="search_panel bottom_left"></div>
          <div class="search_panel bottom_right"></div>
          <div class="search_panel top_left"></div>
          <div class="search_panel top_right"></div>
          <form action="/search_results/index.php" method="post" target="output_frame" class="search_panel search_form">
            <input type="hidden" name="depth" value="<?php echo($session->get("depth", "file_explorer")); ?>" />
            <div class="search_panel middle" id="search_panel_middle">
              <div class="search_panel title">
                Search by any or all of the criteria below.
              </div>
              <div class="search_panel name">
                All or part of the file name:
              </div>
              <div class="search_panel name input">
                <input class="full_width" type="text" name="search_file_name" />
              </div>
              <div class="search_panel text">
                A word or phrase in the file:
              </div>
              <div class="search_panel text input">
                <input class="full_width" type="text" name="search_text" />
              </div>
              <div class="search_panel server">
                Server:
              </div>
              <div class="search_panel server select">
                <select multiple size="4" class="full_width" id="server" name="server_ids[]">
                </select>
              </div>
              <div class="search_panel path">
                Path:
              </div>
              <div class="search_panel path select">
                <select class="full_width" id="path" name="path"></select>
              </div>
              <div class="search_panel date_panel">
                <div class="search_panel date_panel row1">
                  <div class="search_panel date_panel title">
                    When was it modified?
                  </div>
                  <div class="search_panel date_panel expand">
                    <a class="search_panel date_panel expand" href="#" onclick="search_view_toggle_date();">&nbsp;</a>
                  </div>
                </div>
                <div class="search_panel date_panel" id="date_panel" style="display: none;">
                  <div class="search_panel date_panel row2">
                    <div class="search_panel date_panel radio_button0">
                      <input type="radio" name="search_date" value="0" checked="checked" />
                    </div>
                    <div class="search_panel date_panel radio_button0 text">
                      Don't remember
                    </div>
                  </div>
                  <div class="search_panel date_panel row3">
                    <div class="search_panel date_panel radio_button1">
                      <input type="radio" name="search_date" value="1" />
                    </div>
                    <div class="search_panel date_panel radio_button1 text">
                      Within the last week
                    </div>
                  </div>
                  <div class="search_panel date_panel row4">
                    <div class="search_panel date_panel radio_button2">
                      <input type="radio" name="search_date" value="2" />
                    </div>
                    <div class="search_panel date_panel radio_button2 text">
                      Past month
                    </div>
                  </div>
                  <div class="search_panel date_panel row5">
                    <div class="search_panel date_panel radio_button3">
                      <input type="radio" name="search_date" value="3" />
                    </div>
                    <div class="search_panel date_panel radio_button3 text">
                      Within the past year
                    </div>
                  </div>
                  <div class="search_panel date_panel row6">
                    <div class="search_panel date_panel radio_button4">
                      <input type="radio" name="search_date" value="4" />
                    </div>
                    <div class="search_panel date_panel radio_button4 text">
                      Specify dates
                    </div>
                  </div>
                  <div class="search_panel date_panel row7">
                    <div class="search_panel date_panel from">
                      From:
                    </div>
                    <input type="text" value="<?php echo (date("m/d/Y")); ?>" class="search_panel date_panel from_select" name="search_date_low" onclick="server_group_explorer_show_date_picker('search_date_low');" />
                  </div>
                  <div class="search_panel date_panel row8">
                    <div class="search_panel date_panel to">
                      To:
                    </div>
                    <input type="text" value="<?php echo (date("m/d/Y")); ?>" class="search_panel date_panel to_select" name="search_date_high" onclick="server_group_explorer_show_date_picker('search_date_high');" />
                  </div>
                </div>
              </div>
              <div class="search_panel size_panel">
                <div class="search_panel size_panel row1">
                  <div class="search_panel size_panel title">
                    What size is it?
                  </div>
                  <div class="search_panel size_panel expand">
                    <a class="search_panel size_panel expand" href="#" onclick="search_view_toggle_size();">&nbsp;</a>
                  </div>
                </div>
                <div class="search_panel size_panel" id="size_panel" style="display: none;">
                  <div class="search_panel size_panel row2">
                    <div class="search_panel size_panel radio_button0">
                      <input type="radio" name="search_size" value="0" />
                    </div>
                    <div class="search_panel size_panel radio_button0 text">
                      Don't remember
                    </div>
                  </div>
                  <div class="search_panel size_panel row3">
                    <div class="search_panel size_panel radio_button1">
                      <input type="radio" name="search_size" value="1" />
                    </div>
                    <div class="search_panel size_panel radio_button1 text">
                      Small (less than 100 KB)
                    </div>
                  </div>
                  <div class="search_panel size_panel row4">
                    <div class="search_panel size_panel radio_button2">
                      <input type="radio" name="search_size" value="2" />
                    </div>
                    <div class="search_panel size_panel radio_button2 text">
                      Medium (less than 1 MB)
                    </div>
                  </div>
                  <div class="search_panel size_panel row5">
                    <div class="search_panel size_panel radio_button3">
                      <input type="radio" name="search_size" value="3" />
                    </div>
                    <div class="search_panel size_panel radio_button3 text">
                      Large (more than 1 MB)
                    </div>
                  </div>
                  <div class="search_panel size_panel row6">
                    <div class="search_panel size_panel radio_button4">
                      <input type="radio" name="search_size" value="4" />
                    </div>
                    <div class="search_panel size_panel radio_button4 text">
                      Specify size (in KB)
                    </div>
                  </div>
                  <div class="search_panel size_panel row7">
                    <select class="search_panel size_panel type_select" name="search_size_type">
                      <option value="1">at least</option>
                      <option value="0">at most</option>
                    </select>
                    <input class="search_panel size_panel size_input" type="text" name="search_size_value" value="0" />
                  </div>
                </div>
              </div>
              <div class="search_panel submit">
                <input class="search_panel submit button" type="submit" value="Search" style="width:75px;font-size:9pt;" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="common blue_steel panel right_top" style="overflow:hidden;">
      <iframe style="position: absolute;height: 100%;width: 100%;" name="output_frame" src="/common/blank.html"></iframe>
    </div>
    <div class="folder_panel calendar" id="calendar">
<?php
  require_once './Calendar/Month/Weekdays.php';

  $Month = new Calendar_Month_Weekdays(date('Y'), date('n'), 0);

  $Month->build();
  ?>
      <table>
        <caption>
          <?php echo ( date('F Y',$Month->getTimeStamp())); ?>

        </caption>
        <tr>
          <th>S</th>
          <th>M</th>
          <th>T</th>
          <th>W</th>
          <th>T</th>
          <th>F</th>
          <th>S</th>
        </tr>
<?php

  while ($Day = $Month->fetch()) {
    if ($Day->isFirst()) {
      echo "        <tr>\n";
    }

    if ($Day->isEmpty()) {
      echo "          <td>&nbsp;</td>\n";
    } else {
      echo '          <td>'.$Day->thisDay()."</td>\n";
    }

    if ($Day->isLast()) {
      echo "        </tr>\n";
    }
  }

?>
      </table>
    </div>
    <div class="folder_panel server_group context_menu" id="server_group_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_open_item');" title="Show Details"><b>Show Details</b></a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_expand_item');" title="Expand this item">Expand</a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_explore_from_here');" title="Explore from here">Explore from here</a></span>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_show_properties');" title="Display standard properties of the server_group">Properties</a>
    </div>
    <div class="folder_panel server context_menu" id="server_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_open_item');" title="Show Details"><b>Show Details</b></a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_expand_item');" title="Expand this item">Expand</a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_explore_from_here');" title="Explore from here">Explore from here</a></span>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_show_properties');" title="Display standard properties of the server">Properties</a>
    </div>
    <div class="folder_panel directory context_menu" id="directory_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_open_item');" title="Show Details"><b>Show Details</b></a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_expand_item');" title="Expand this item">Expand</a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_explore_item');" title="Make this item the root">Explore From Here</a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('compare_items_add_item');" title="Compare this directory">Compare Directory</a></span>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_download_item();" title="Download this item"><img class="context_menu icon" src="/common/images/download_folderico.png" alt="Download" />Download Folder</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_show_properties');" title="Display standard properties of the directory">Properties</a>
    </div>
    <div class="folder_panel file context_menu" id="file_context_menu">
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_open_item');" title="Open File"><b>Open File</b></a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('server_group_explorer_tail_file');" title="Tail this file">Tail File</a></span>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click('compare_items_add_item');" title="Compare this file">Compare File</a></span>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="context_menu_download_item();" title="Download this item"><img class="context_menu icon" src="/common/images/download_folderico.png" alt="Download" />Download File</a>
      <div class="context_menu horizontal_rule"></div>
      <a class="context_menu" href="#" onclick="history.go(0);" title="Refresh the contents of this page"><img class="context_menu icon" src="/common/images/refreshico.png" alt="Refresh" />Refresh</a>
      <a class="context_menu indent" href="#" onclick="context_menu_item_click();" title="Display standard properties of the file">Properties</a>
    </div>
  </body>
</html>
