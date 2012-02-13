<?php

  @require_once ("../common/include/ajax_header.inc");

  $row = $common->get_query_string($_GET, 'row');

  if (!isset($_COOKIE['compare_items'])) {
    exit(0);
  }

  if ($row == "all") {
    foreach ($_COOKIE['compare_items'] as $pos => $row) {
      setcookie("compare_items[".$pos."][type]", $row['type'], time() - 3600, "/compare_items/");
      setcookie("compare_items[".$pos."][server]", $row['server'], time() - 3600, "/compare_items/");
      setcookie("compare_items[".$pos."][path]", $row['path'], time() - 3600, "/compare_items/");
    }
    exit(0);
  }

  array_splice($_COOKIE['compare_items'], $row, 1);

  var_export($_COOKIE['compare_items']);

  foreach ($_COOKIE['compare_items'] as $pos => $row) {
    setcookie("compare_items[".$pos."][type]", $row['type'], time() + 3600, "/compare_items/");
    setcookie("compare_items[".$pos."][server]", $row['server'], time() + 3600, "/compare_items/");
    setcookie("compare_items[".$pos."][path]", $row['path'], time() + 3600, "/compare_items/");
  }
  $pos = count($_COOKIE['compare_items']);
  setcookie("compare_items[".$pos."][type]", "", time() - 3600, "/compare_items/");
  setcookie("compare_items[".$pos."][server]", "", time() - 3600, "/compare_items/");
  setcookie("compare_items[".$pos."][path]", "", time() - 3600, "/compare_items/");


?>
