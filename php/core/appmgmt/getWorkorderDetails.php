<?php

  include ("../../docroot/common/include/backend_header.inc");

//  $wo_id=$ARGV['wo_id'];
  $wo_id=$_GET['wo_id'];

  $detail_arr = array();
  $detail_arr = $database->kb_get_wo_detail($wo_id);

  $result_arr = array();
  $result_arr['app_home']=$detail_arr[0]['app_home'];
  $result_arr['app_user']=$detail_arr[0]['app_user'];
  $result_arr['script']=$detail_arr[0]['script'];
  $result_arr['args']=$detail_arr[0]['arguments'];

  echo ('<?php $_WO_DETAIL[\'wod\'] = ');
  echo (var_export($result_arr)."; ?>");


?>
  
