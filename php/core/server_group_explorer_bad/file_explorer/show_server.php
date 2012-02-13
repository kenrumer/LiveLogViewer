<?php

  @require_once("../common/include/header.inc");

  $id = $common->get_query_string($_GET, 'server_id');
  $server = $database->get_server($id);
  require ("http://".urlencode($session->get("user_name", "node_php")).":".urlencode($session->get("passwd", "node_php"))."@".$frontend_server."/".$server['fqdn']."/get_sys_info.php");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      <?php echo ($server); ?> Properties
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common2.css" type="text/css" />
    <link rel="stylesheet" href="/common/css/blue_steel.css" type="text/css" />
    <link rel="stylesheet" href="css/file_explorer.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/common/jscript/common.js" type="text/javascript"></script>
    <script src="/common/jscript/context_menu.js" type="text/javascript"></script>
    <script src="/compare_items/jscript/compare_items.js" type="text/javascript"></script>
    <script src="jscript/file_explorer.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body class="common blue_steel">
    <div class="common blue_steel background">
      <div class="common blue_steel panel vitals">
        <div class="common blue_steel title">
          System Vitals
        </div>
        <div class="common blue_steel content with_title">
          <table border="0" width="100%" align="center">
            <tr>
              <td valign="top"><font size="-1">Canonical Hostname</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['chostname']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Listening IP</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['ip_addr']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Virtual Hostname</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['vhostname']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Virtual IP</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['vip_addr']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Kernel Version</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['kernel']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Distro Name</font></td>
              <td><img width="16" height="16" alt="" src="/common/images/<?php echo $_SYSINFO[$server['fqdn']]['vitals']['distroicon'] ?>">&nbsp;<font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['distro']; ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Uptime</font></td>
              <td><font size="-1"><?php echo $common->format_time($_SYSINFO[$server['fqdn']]['vitals']['uptime']); ?></font></td>
            </tr>
            <tr>
              <td valign="top"><font size="-1">Current Users</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['vitals']['users']; ?></font></td>
            </tr>
<?php

  $strLoadavg = "";
  $strLoadbar = "";

  if (isset($_SYSINFO[$server['fqdn']]['vitals']['loadavg']['cpupercent'])) {
    $strLoadbar = "<br>" . $common->create_bargraph($_SYSINFO[$server['fqdn']]['vitals']['loadavg']['cpupercent'], 100, 2)."&nbsp;".$_SYSINFO[$server['fqdn']]['vitals']['loadavg']['cpupercent'];
  }
  foreach($_SYSINFO[$server['fqdn']]['vitals']['loadavg']['avg'] as $strValue) {
    $strLoadavg .= $strValue . '&nbsp;';
  }

?>
            <tr>
              <td valign="top"><font size="-1">Load Averages</font></td>
              <td><font size="-1"><?php echo "$strLoadavg$strLoadbar"; ?></font></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="common blue_steel panel hardware">
        <div class="common blue_steel title">
          Hardware Information
        </div>
        <div class="common blue_steel content with_title">
          <table border="0" width="100%" align="center">
<?php

  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['cpus'])) {

?>
            <tr>
              <td valign="top"><font size="-1">Processors</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['hardware']['cpu']['cpus']; ?></font></td>
            </tr>
<?php

  }
  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['model'])) {

?>
            <tr>
              <td valign="top"><font size="-1">Model</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['hardware']['cpu']['model']; ?></font></td>
            </tr>
<?php

  }
  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['cpuspeed'])) {

?>
            <tr>
              <td valign="top"><font size="-1">CPU Speed</font></td>
              <td><font size="-1"><?php echo $common->format_speed($_SYSINFO[$server['fqdn']]['hardware']['cpu']['cpuspeed']); ?></font></td>
            </tr>
<?php

  }
  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['busspeed'])) {

?>
            <tr>
              <td valign="top"><font size="-1">BUS Speed</font></td>
              <td><font size="-1"><?php echo $common->format_speed($_SYSINFO[$server['fqdn']]['hardware']['cpu']['busspeed']); ?></font></td>
            </tr>
<?php

  }
  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['cache'])) {

?>
            <tr>
              <td valign="top"><font size="-1">Cache Size</font></td>
              <td><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['hardware']['cpu']['cache']); ?></font></td>
            </tr>
<?php

  }
  if (isset($_SYSINFO[$server['fqdn']]['hardware']['cpu']['bogomips'])) {

?>
            <tr>
              <td valign="top"><font size="-1">System Bogomips</font></td>
              <td><font size="-1"><?php echo $_SYSINFO[$server['fqdn']]['hardware']['cpu']['bogomips']; ?></font></td>
            </tr>
<?php

  }
  if (count($_SYSINFO[$server['fqdn']]['hardware']['pci']) > 0) {

?>
            <tr>
              <td colspan="2">
                <a href="#" onclick="var objDevList = document.getElementById('pciDeviceList'); objDevList.style.display!='none'?objDevList.style.display='none':objDevList.style.display='inline';">PCI Device List</a><br />
                <ul id="pciDeviceList" style="display: none">
<?php

    foreach ($_SYSINFO[$server['fqdn']]['hardware']['pci'] as $pci) {

?>
                  <li><?php echo $pci; ?></li>
<?php

    }

?>
                </ul>
              </td>
            </tr>
<?php

  }
  if (count($_SYSINFO[$server['fqdn']]['hardware']['ide']) > 0) {

?>
            <tr>
              <td colspan="2">
                <a href="#" onclick="var objDevList = document.getElementById('ideDeviceList'); objDevList.style.display!='none'?objDevList.style.display='none':objDevList.style.display='inline';">IDE Device List</a><br />
                <ul id="ideDeviceList" style="display: none">
<?php

    foreach ($_SYSINFO[$server['fqdn']]['hardware']['ide'] as $ide) {

?>
                  <li><?php

      echo $ide['model'];
      if (isset($ide['capacity'])) {
        echo "(Capacity: ".$common->format_bytesize($ide['capacity']).")";
      }

?></li>
<?php

    }

?>
                </ul>
              </td>
            </tr>
<?php

  }
  if (count($_SYSINFO[$server['fqdn']]['hardware']['scsi']) > 0) {

?>
            <tr>
              <td colspan="2">
                <a href="#" onclick="var objDevList = document.getElementById('scsiDeviceList'); objDevList.style.display!='none'?objDevList.style.display='none':objDevList.style.display='inline';">SCSI Device List</a><br />
                <ul id="scsiDeviceList" style="display: none">
<?php

    foreach ($_SYSINFO[$server['fqdn']]['hardware']['scsi'] as $scsi) {

?>
                  <li><?php

      echo $scsi['model'];
      if (isset($scsi['capacity'])) {
        echo "(Capicity: ".$common->format_bytesize($scsi['capacity']).")";
      }

?></li>
<?php

    }

?>
                </ul>
              </td>
            </tr>
<?php

  }
  if (count($_SYSINFO[$server['fqdn']]['hardware']['usb']) > 0) {

?>
            <tr>
              <td colspan="2">
                <a href="#" onclick="var objDevList = document.getElementById('usbDeviceList'); objDevList.style.display!='none'?objDevList.style.display='none':objDevList.style.display='inline';">USB Device List</a><br />
                <ul id="usbDeviceList" style="display: none">
<?php

    foreach ($_SYSINFO[$server['fqdn']]['hardware']['usb'] as $usb) {

?>
                  <li><?php echo $usb; ?></li>
<?php

    }

?>
                </ul>
              </td>
            </tr>
<?php

  }

?>
          </table>
        </div>
      </div>
      <div class="common blue_steel panel memory">
        <div class="common blue_steel title">
          Memory Usage
        </div>
        <div class="common blue_steel content with_title">
          <table border="0" width="100%" align="center">
<?php

  $strRam = $common->create_bargraph($_SYSINFO[$server['fqdn']]['memory']['ram']['used'], $_SYSINFO[$server['fqdn']]['memory']['ram']['total'], 2);
  $strRam .= "&nbsp;&nbsp;".$_SYSINFO[$server['fqdn']]['memory']['ram']['percent']."% ";

  if (isset($_SYSINFO[$server['fqdn']]['memory']['swap']['total'])) {
    $strSwap = $common->create_bargraph($_SYSINFO[$server['fqdn']]['memory']['swap']['used'], $_SYSINFO[$server['fqdn']]['memory']['swap']['total'], 2);
    $strSwap .= "&nbsp;&nbsp;".$_SYSINFO[$server['fqdn']]['memory']['swap']['percent']."% ";
  }

  if (isset($_SYSINFO[$server['fqdn']]['memory']['ram']['app_percent'])) {
    $strApp = $common->create_bargraph($_SYSINFO[$server['fqdn']]['memory']['ram']['app'], $_SYSINFO[$server['fqdn']]['memory']['ram']['total'], 2);
    $strApp .= "&nbsp;&nbsp;".$_SYSINFO[$server['fqdn']]['memory']['ram']['app_percent']."% ";
  }

  if (isset($_SYSINFO[$server['fqdn']]['memory']['ram']['buffers_percent'])) {
    $strBuffers = $common->create_bargraph($_SYSINFO[$server['fqdn']]['memory']['ram']['buffers'], $_SYSINFO[$server['fqdn']]['memory']['ram']['total'], 2);
    $strBuffers .= "&nbsp;&nbsp;".$_SYSINFO[$server['fqdn']]['memory']['ram']['buffers_percent']."% ";
  }

  if (isset($_SYSINFO[$server['fqdn']]['memory']['ram']['cached_percent'])) {
    $strCached = $common->create_bargraph($_SYSINFO[$server['fqdn']]['memory']['ram']['cached'], $_SYSINFO[$server['fqdn']]['memory']['ram']['total'], 2);
    $strCached .= "&nbsp;&nbsp;".$_SYSINFO[$server['fqdn']]['memory']['ram']['cached_percent']."% ";
  }

?>
            <tr>
              <td align="left" valign="top"><font size="-1"><b>Type</b></font></td>
              <td align="left" valign="top"><font size="-1"><b>Percent</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Free</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Used</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Size</b></font></td>
            </tr>
            <tr>
              <td align="left" valign="top"><font size="-1">Physical Memory</font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strRam; ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['free']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['used']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['total']); ?></font></td>
            </tr>
<?php

  if (isset($strApp)) {

?>
            <tr>
              <td align="left" valign="top"><font size="-1">- Kernel + applications</font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strApp; ?></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['app']); ?></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
            </tr>
<?php

  }

?>
<?php

  if (isset($strBuffers)) {

?>
            <tr>
              <td align="left" valign="top"><font size="-1">- Buffers</font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strApp; ?></b></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['buffers']); ?></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
            </tr>
<?php

  }

?>
<?php

  if (isset($strCached)) {

?>
            <tr>
              <td align="left" valign="top"><font size="-1">Cached</font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strCached; ?></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['ram']['cached']); ?></font></td>
              <td align="right" valign="top"><font size="-1">&nbsp;</font></td>
            </tr>
<?php

  }

?>
<?php

  if (isset($strSwap)) {

?>
            <tr>
              <td align="left" valign="top"><font size="-1">Disk Swap</font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strSwap; ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['swap']['free']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['swap']['used']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($_SYSINFO[$server['fqdn']]['memory']['swap']['total']); ?></font></td>
            </tr>
<?php

  }

?>
<?php

  foreach($_SYSINFO[$server['fqdn']]['memory']['devswap'] as $arrDevice) {
    $strSwapdev = $common->create_bargraph($arrDevice['used'], $arrDevice['total'], 2);
    $strSwapdev .= "&nbsp;&nbsp;".$arrDevice['percent']."% ";

?>
            <tr>
              <td align="left" valign="top"><font size="-1"><?php echo $arrDevice['dev']; ?></font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $strSwapdev; ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrDevice['free']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrDevice['used']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrDevice['total']); ?></font></td>
            </tr>
<?php

  }

?>
          </table>
        </div>
      </div>
      <div class="common blue_steel panel network">
        <div class="common blue_steel title">
          Network Usage
        </div>
        <div class="common blue_steel content with_title">
          <table border="0" width="100%" align="center">
            <tr>
              <td align="left" valign="top"><font size="-1"><b>Device</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Received</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Sent</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Err/Drop</b></font></td>
            </tr>
<?php

  foreach ($_SYSINFO[$server['fqdn']]['network'] as $name => $stats) {

?>
            <tr>
              <td align="left" valign="top"><font size="-1"><?php echo $name; ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($stats['rx_bytes']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($stats['tx_bytes']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $stats['drop']; ?></font></td>
            </tr>
<?php

  }

?>
          </table>
        </div>
      </div>
      <div class="common blue_steel panel filesystems">
        <div class="common blue_steel title">
          Mounted Filesystems
        </div>
        <div class="common blue_steel content with_title">
          <table border="0" width="100%" align="center">
            <tr>
              <td align="left" valign="top"><font size="-1"><b>Mount</b></font></td>
              <td align="left" valign="top"><font size="-1"><b>Type</b></font></td>
              <td align="left" valign="top"><font size="-1"><b>Partition</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Percent Capacity</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Free</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Used</b></font></td>
              <td align="right" valign="top"><font size="-1"><b>Size</b></font></td>
              </td>
            </tr>
<?php

  $arrSum = array("size" => 0, "used" => 0, "free" => 0);
  foreach ($_SYSINFO[$server['fqdn']]['filesystems'] as $filesystem) {
    $arrSum['size'] += $filesystem['size'];
    $arrSum['used'] += $filesystem['used'];
    $arrSum['free'] += $filesystem['free'];

?>
            <tr>
              <td align="left" valign="top"><font size="-1"><?php echo $filesystem['mount'] ?></font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $filesystem['fstype'] ?></font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $filesystem['disk'] ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->create_bargraph($filesystem['used'], $filesystem['size'], 2, $filesystem['fstype'])."&nbsp;".$filesystem['percent']."%"; ?>
<?php

  if (isset($filesystem['inodes'])) {
    echo $filesystem['inodes'];
  }

?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($filesystem['free']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($filesystem['used']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($filesystem['size']); ?></font></td>
            </tr>
<?php

  }

?>
            <tr>
              <td colspan="3" align="right" valign="top"><font size="-1"><i>Totals :&nbsp;&nbsp;</i></font></td>
              <td align="left" valign="top"><font size="-1"><?php echo $common->create_bargraph($arrSum['used'], $arrSum['size'], 2); ?>&nbsp;
<?php

  if ($arrSum['size'] == 0) {
    echo "0";
  } else {
    echo round(100/$arrSum['size']*$arrSum['used']);
  }

?>%</font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrSum['free']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrSum['used']); ?></font></td>
              <td align="right" valign="top"><font size="-1"><?php echo $common->format_bytesize($arrSum['size']); ?></font></td>
            <tr>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
