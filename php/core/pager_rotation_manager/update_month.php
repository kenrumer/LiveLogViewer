<?php

  include ("../common/include/common.inc");
  include ("calendar.inc");

  $common = new common();
  $calendar = new calendar();

  $month = $common->get_query_string($_GET, "month");
  $year = $common->get_query_string($_GET, "year");
  $calendar = new Calendar();
  echo $calendar->getMonthView($month, $year);

?>
