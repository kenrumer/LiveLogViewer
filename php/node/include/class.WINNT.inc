<?php

  class sysinfo {

    private $wmi; 
    private $wmidevices;

    public function sysinfo () {

      $objLocator = new COM("WbemScripting.SWbemLocator");
      $this->wmi = $objLocator->ConnectServer();

    }

    private function _GetWMI($strClass, $strValue = array() ) {

      $objWEBM = $this->wmi->Get($strClass);
      $arrProp = $objWEBM->Properties_;
      $arrWEBMCol = $objWEBM->Instances_();

      foreach($arrWEBMCol as $objItem) {
        @reset($arrProp);
        $arrInstance = array();
        foreach($arrProp as $propItem) {
          eval("\$value = \$objItem->" .$propItem->Name .";");
          if( empty( $strValue ) ) {
            $arrInstance[$propItem->Name] = trim($value);
          } else {
            if( in_array( $propItem->Name, $strValue ) ) {
              $arrInstance[$propItem->Name] = trim($value);
            }
          }
        }
        $arrData[] = $arrInstance;
      }
      return $arrData;
    }

    private function _devicelist ( $strType ) {

      if( empty( $this->wmidevices ) ) {
        $this->wmidevices = $this->_GetWMI( "Win32_PnPEntity", array( "Name", "PNPDeviceID" ) );
      }
      
      $list = array();
      foreach ( $this->wmidevices as $device ) {
        if ( substr( $device["PNPDeviceID"], 0, strpos( $device["PNPDeviceID"], "\\" ) + 1 ) == ( $strType . "\\" ) ) {
          $list[] = $device["Name"];
        } 
      }
      
      return $list;

    }

    public function vhostname () {

      if (! ($result = getenv('SERVER_NAME'))) {
        $result = 'N.A.';
      } 
      return $result;

    }

    public function vip_addr () {

      return gethostbyname($this->vhostname());

    }

    public function chostname () {

      $buffer = $this->_GetWMI( "Win32_ComputerSystem", array( "Name" ) );
      $result = $buffer[0]["Name"];
      return gethostbyaddr(gethostbyname($result));

    }

    public function ip_addr () {

      $buffer = $this->_GetWMI( "Win32_ComputerSystem", array( "Name" ) );
      $result = $buffer[0]["Name"];
      return gethostbyname($result);

    }

    public function kernel () {

      $buffer = $this->_GetWMI( "Win32_OperatingSystem", array( "Version", "ServicePackMajorVersion" ) );
      $result = $buffer[0]["Version"];
      if( $buffer[0]["ServicePackMajorVersion"] > 0 ) {
        $result .= " SP" . $buffer[0]["ServicePackMajorVersion"];
      }
      return $result;

    } 

    public function uptime () {

      $result = 0;
      $buffer = $this->_GetWMI( "Win32_OperatingSystem", array( "LastBootUpTime", "LocalDateTime" ) );

      $byear = intval(substr($buffer[0]["LastBootUpTime"], 0, 4));
      $bmonth = intval(substr($buffer[0]["LastBootUpTime"], 4, 2));
      $bday = intval(substr($buffer[0]["LastBootUpTime"], 6, 2));
      $bhour = intval(substr($buffer[0]["LastBootUpTime"], 8, 2));
      $bminute = intval(substr($buffer[0]["LastBootUpTime"], 10, 2));
      $bseconds = intval(substr($buffer[0]["LastBootUpTime"], 12, 2));

      $lyear = intval(substr($buffer[0]["LocalDateTime"], 0, 4));
      $lmonth = intval(substr($buffer[0]["LocalDateTime"], 4, 2));
      $lday = intval(substr($buffer[0]["LocalDateTime"], 6, 2));
      $lhour = intval(substr($buffer[0]["LocalDateTime"], 8, 2));
      $lminute = intval(substr($buffer[0]["LocalDateTime"], 10, 2));
      $lseconds = intval(substr($buffer[0]["LocalDateTime"], 12, 2));

      $boottime = mktime($bhour, $bminute, $bseconds, $bmonth, $bday, $byear);
      $localtime = mktime($lhour, $lminute, $lseconds, $lmonth, $lday, $lyear);

      $result = $localtime - $boottime;

      return $result;

    } 

    public function users () {

      if (stristr($this->kernel(), "2000 P")) return "N.A.";
      $buffer = $this->_GetWMI( "Win32_PerfRawData_TermService_TerminalServices", array( "TotalSessions" ) );
      return $buffer[0]["TotalSessions"];

    }

    public function loadavg ($bar = true) {

      $buffer = $this->_GetWMI( "Win32_Processor", array( "LoadPercentage" ) );
      $cpuload = array();
      for( $i = 0; $i < count( $buffer ); $i++ ) {
        $cpuload['avg'][] = $buffer[$i]["LoadPercentage"];
      }
      if ($bar) {
        $cpuload['cpupercent'] = array_sum( $cpuload['avg'] ) / count( $buffer );
      }
      return $cpuload;

    } 

    public function cpu_info () {

      $buffer = $this->_GetWMI( "Win32_Processor", array( "Name", "L2CacheSize", "CurrentClockSpeed", "ExtClock" ) );
      $results["cpus"] = 0;
      foreach ($buffer as $cpu) {
        $results["cpus"]++;
        $results["model"] = $cpu["Name"];
        $results["cache"] = $cpu["L2CacheSize"];
        $results["cpuspeed"] = $cpu["CurrentClockSpeed"];
        $results["busspeed"] = $cpu["ExtClock"];
      } 
      return $results;

    }

    public function pci () {

      $pci = $this->_devicelist("PCI");
      return $pci;

    } 

    public function ide () {

      $buffer = $this->_devicelist("IDE");
      $ide = array();
      foreach ( $buffer as $device ) {
        $ide[]['model'] = $device;
      }
      return $ide;
    }

    public function scsi () {

      $scsi = $this->_devicelist( "SCSI" );
      return $scsi;

    }

    public function usb () {

      $usb = $this->_devicelist( "USB" );
      return $usb;

    } 

    public function sbus () {

      $sbus = $this->_devicelist( "SBUS" );
      return $sbus;

    } 

    public function network () {

      $results = array();
      $buffer = $this->_GetWMI( "Win32_PerfRawData_Tcpip_NetworkInterface" );
      foreach( $buffer as $device ) {
        $dev_name = $device["Name"];
        if ( $device["BytesSentPersec"] < 0) {
          $results[$dev_name]['tx_bytes'] = $device["BytesTotalPersec"] - $device["BytesReceivedPersec"];
        } else {
          $results[$dev_name]['tx_bytes'] = $device["BytesSentPersec"];
        }
        if( $device["BytesReceivedPersec"] < 0 ) {
          $results[$dev_name]['rx_bytes'] = $device["BytesTotalPersec"] - $device["BytesSentPersec"];
        } else {
          $results[$dev_name]['rx_bytes'] = $device["BytesReceivedPersec"];
        }

        $results[$dev_name]['rx_packets'] = $device["PacketsReceivedPersec"];
        $results[$dev_name]['tx_packets'] = $device["PacketsSentPersec"];
        $results[$dev_name]['rx_errs'] = $device["PacketsReceivedErrors"];
        $results[$dev_name]['rx_drop'] = $device["PacketsReceivedDiscarded"];
        $results[$dev_name]['errs'] = $device["PacketsReceivedErrors"];
        $results[$dev_name]['drop'] = $device["PacketsReceivedDiscarded"];
      }

      return $results;

    } 

    public function memory () {

      $buffer = $this->_GetWMI( "Win32_LogicalMemoryConfiguration", array( "TotalPhysicalMemory" ) );
      $results['ram']['total'] = $buffer[0]["TotalPhysicalMemory"];

      $buffer = $this->_GetWMI( "Win32_PerfRawData_PerfOS_Memory", array( "AvailableKBytes" ) );
      $results['ram']['free'] = $buffer[0]["AvailableKBytes"];

      $results['ram']['used'] = $results['ram']['total'] - $results['ram']['free'];
      $results['ram']['percent'] = ceil( ( $results['ram']['used'] * 100 ) / $results['ram']['total'] );
      $results['swap']['total'] = 0;
      $results['swap']['used'] = 0;
      $results['swap']['free'] = 0;

      $buffer = $this->_GetWMI( "Win32_PageFileUsage" ); // no need to filter, using nearly everything from output
      $k = 0;
      foreach ($buffer as $swapdevice) {
        $results['devswap'][$k]['dev'] = $swapdevice["Name"];
        $results['devswap'][$k]['total'] = $swapdevice["AllocatedBaseSize"] * 1024;
        $results['devswap'][$k]['used'] = $swapdevice["CurrentUsage"] * 1024;
        $results['devswap'][$k]['free'] = ( $swapdevice["AllocatedBaseSize"] - $swapdevice["CurrentUsage"] ) * 1024;
        $results['devswap'][$k]['percent'] = ceil( $swapdevice["CurrentUsage"] / $swapdevice["AllocatedBaseSize"] );

        $results['swap']['total'] += $results['devswap'][$k]['total'];
        $results['swap']['used'] += $results['devswap'][$k]['used'];
        $results['swap']['free'] += $results['devswap'][$k]['free'];
        $k += 1;
      }
      $results['swap']['percent'] = ceil( $results['swap']['used'] / $results['swap']['total'] * 100 );
      return $results;

    }

    public function filesystems () {
      $results = array();

      $typearray = array("Unknown", "No Root Directory", "Removeable Disk",
        "Local Disk", "Network Drive", "Compact Disc", "RAM Disk");
      $floppyarray = array("Unknown", "5 1/4 in.", "3 1/2 in.", "3 1/2 in.",
        "3 1/2 in.", "3 1/2 in.", "5 1/4 in.", "5 1/4 in.", "5 1/4 in.",
        "5 1/4 in.", "5 1/4 in.", "Other", "HD", "3 1/2 in.", "3 1/2 in.",
        "5 1/4 in.", "5 1/4 in.", "3 1/2 in.", "3 1/2 in.", "5 1/4 in.",
        "3 1/2 in.", "3 1/2 in.", "8 in.");

      $buffer = $this->_GetWMI( "Win32_LogicalDisk" , array( "Name", "Size", "FreeSpace", "FileSystem", "DriveType", "MediaType" ) );

      $k = 0;
      foreach ( $buffer as $filesystem ) {
        $results[$k]['mount'] = $filesystem["Name"];
        $results[$k]['size'] = $filesystem["Size"] / 1024;
        $results[$k]['used'] = ( $filesystem["Size"] - $filesystem["FreeSpace"] ) / 1024;
        $results[$k]['free'] = $filesystem["FreeSpace"] / 1024;
        @$results[$k]['percent'] = ceil( $results[$k]['used'] / $results[$k]['size'] * 100 );
        $results[$k]['fstype'] = $filesystem["FileSystem"];
        $results[$k]['disk'] = $typearray[$filesystem["DriveType"]];
        if ( $filesystem["MediaType"] != ""  && $filesystem["DriveType"] == 2 ) $results[$k]['disk'] .= " (" . $floppyarray[$filesystem["MediaType"]] . ")";
        $k += 1;
      } 
      return $results;

    } 

    public function distro () {

      $buffer = $this->_GetWMI( "Win32_OperatingSystem", array( "Caption" ) );
      return $buffer[0]["Caption"];

    } 

    public function distroicon () {

      return 'xp.gif';

    }

    public function finddups( $arrInput ) {
      $arrResult = array();
      
      if( is_array( $arrInput ) ) {
        $arrBuffer = array_count_values( $arrInput );
        foreach( $arrBuffer as $strKey => $intValue) {
          if( $intValue > 1 ) {
            $arrResult[] = "(" . $intValue . "x) " . $strKey;
          } else {
            $arrResult[] = $strKey;
          }
        }
      }
      
      return $arrResult;

    }

  }

?>