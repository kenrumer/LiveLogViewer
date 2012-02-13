<?php

  @require_once ("../common/include/ajax_header.inc");

  $file = $common->get_query_string($_GET, "file");
  $server_id = $common->get_query_string($_GET, "server_id");
  $search_text = $common->get_query_string($_GET, "search_text");

  $server = $database->get_server($server_id);

  if (isset($_SERVER['HTTPS'])) {
    readfile ("https://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_matching_text.php?file=".urlencode($file)."&search_text=".urlencode($search_text));
  } else {
    readfile ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_matching_text.php?file=".urlencode($file)."&search_text=".urlencode($search_text));
  }

?>

