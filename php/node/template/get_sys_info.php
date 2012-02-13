<?php

  require_once("../include/common.inc");
  require_once("../include/class.".PHP_OS.".inc");

  $common = new common();
  $sysinfo = new sysinfo();
  $ret_array = array();

  $ret_array['vitals']['vhostname'] = $sysinfo->vhostname();
  $ret_array['vitals']['chostname'] = $sysinfo->chostname();
  $ret_array['vitals']['vip_addr'] = $sysinfo->vip_addr();
  $ret_array['vitals']['ip_addr'] = $sysinfo->ip_addr();
  $ret_array['vitals']['kernel'] = $sysinfo->kernel();
  $ret_array['vitals']['distro'] = $sysinfo->distro();
  $ret_array['vitals']['distroicon'] = $sysinfo->distroicon();
  $ret_array['vitals']['uptime'] = $sysinfo->uptime();
  $ret_array['vitals']['users'] = $sysinfo->users();
  $ret_array['vitals']['loadavg'] = $sysinfo->loadavg();
  $ret_array['network'] = $sysinfo->network();
  $ret_array['hardware']['cpu'] = $sysinfo->cpu_info();
  $ret_array['hardware']['pci'] = $common->finddups($sysinfo->pci());
  $ret_array['hardware']['ide'] = $sysinfo->ide();
  $ret_array['hardware']['scsi'] = $sysinfo->scsi();
  $ret_array['hardware']['usb'] = $common->finddups($sysinfo->usb());
  $ret_array['memory'] = $sysinfo->memory();
  $ret_array['filesystems'] = $sysinfo->filesystems();

  echo ('<?php');
  echo (' $_SYSINFO[\''.$common->get_hostname().'\'] = ');
  echo (var_export($ret_array)."; ?>\n");

?>
