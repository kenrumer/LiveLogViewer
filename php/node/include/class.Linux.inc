<?php

  require_once('class.BSD.common.inc');

  class sysinfo {
  	var $inifile = "distros.ini";
  	var $icon = "unknown.png";
  	var $distro = "unknown";
  	var $parser;

	  public function sysinfo() {

      $this->parser = new Parser();
  		$this->parser->df_param = 'P';
		
  		$list = @parse_ini_file(APP_ROOT . "/" . $this->inifile, true);
  		if (!$list) {
  			return;
  		}
		
  		$distro_info = execute_program('lsb_release','-a 2> /dev/null', false);
  		if ( $distro_info != 'ERROR') {
  			$distro_tmp = split("\n",$distro_info);
  			foreach( $distro_tmp as $info ) {
  				$info_tmp = split(':', $info, 2);
  				$distro[ $info_tmp[0] ] = trim($info_tmp[1]);
  			}
  			if( !isset( $list[$distro['Distributor ID']] ) ){
  				return;
  			}
  			$this->icon = isset($list[$distro['Distributor ID']]["Image"]) ? $list[$distro['Distributor ID']]["Image"] : $this->icon;
  			$this->distro = $distro['Description'];
  		} else {
  			foreach ($list as $section => $distribution) {
  				if (!isset($distribution["Files"])) {
  					continue;
  				} else {
  					foreach (explode(";", $distribution["Files"]) as $filename) {
  						if (file_exists($filename)) {
  							$buf = rfts( $filename );
  							$this->icon = isset($distribution["Image"]) ? $distribution["Image"] : $this->icon;
  							$this->distro = isset($distribution["Name"]) ? $distribution["Name"] . " " . trim($buf) : trim($buf);
  							break 2;
  						}
  					}
  				}
  			}
  		}
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
      $result = rfts( '/proc/sys/kernel/hostname', 1 );
      if ( $result == "ERROR" ) {
        $result = "N.A.";
      } else {
        $result = gethostbyaddr( gethostbyname( trim( $result ) ) );
      } 
      return $result;
    } 

    public function ip_addr () {
      if (!($result = getenv('SERVER_ADDR'))) {
        $result = gethostbyname($this->chostname());
      } 
      return $result;
    }

    public function kernel () {

      $buf = rfts( '/proc/version', 1 );
      if ( $buf == "ERROR" ) {
        $result = "N.A.";
      } else {
        if (preg_match('/version (.*?) /', $buf, $ar_buf)) {
          $result = $ar_buf[1];

          if (preg_match('/SMP/', $buf)) {
            $result .= ' (SMP)';
          } 
        } 
      } 
      return $result;

    }
  
    public function uptime () {

      $buf = rfts( '/proc/uptime', 1 );
      $ar_buf = split( ' ', $buf );
      $result = trim( $ar_buf[0] );

      return $result;

    } 

    public function users () {

      $strResult = 0;
      $strBuf = execute_program('who', '-q');
      if( $strBuf != "ERROR" ) {
        $arrWho = split( '=', $strBuf );
        $strResult = $arrWho[1];
      }
      return $strResult;

    }

    public function loadavg ($bar = false) {
      $buf = rfts( '/proc/loadavg' );

      if( $buf == "ERROR" ) {
        $results['avg'] = array('N.A.', 'N.A.', 'N.A.');
      } else {
        $results['avg'] = preg_split("/\s/", $buf, 4);
        unset($results['avg'][3]);	// don't need the extra values, only first three
      } 
      if ($bar) {
        $buf = rfts( '/proc/stat', 1 );
        if( $buf != "ERROR" ) {
          sscanf($buf, "%*s %Ld %Ld %Ld %Ld", $ab, $ac, $ad, $ae);
          $load = $ab + $ac + $ad;
          $total = $ab + $ac + $ad + $ae;

          sleep(1);
          $buf = rfts( '/proc/stat', 1 );
          sscanf($buf, "%*s %Ld %Ld %Ld %Ld", $ab, $ac, $ad, $ae);
          $load2 = $ab + $ac + $ad;
          $total2 = $ab + $ac + $ad + $ae;
          $results['cpupercent'] = (100*($load2 - $load)) / ($total2 - $total);
        }
      }
      return $results;

    }

  	public function cpu_info () {
  		$bufr = rfts( '/proc/cpuinfo' );
  		$results = array("cpus" => 0);

  		if ( $bufr != "ERROR" ) {
  			$bufe = explode("\n", $bufr);

  			$results = array('cpus' => 0, 'bogomips' => 0);
  			$ar_buf = array();

      foreach( $bufe as $buf ) {
      	$arrBuff = preg_split('/\s+:\s+/', trim($buf));
      	if( count( $arrBuff ) == 2 ) {
      		$key = $arrBuff[0];
      		$value = $arrBuff[1];
      		switch ($key) {
            case 'model name':
            	$results['model'] = $value;
            	break;
            case 'cpu MHz':
            	$results['cpuspeed'] = sprintf('%.2f', $value);
            	break;
            case 'cycle frequency [Hz]': // For Alpha arch - 2.2.x
            	$results['cpuspeed'] = sprintf('%.2f', $value / 1000000);
            	break;
            case 'clock': // For PPC arch (damn borked POS)
            	$results['cpuspeed'] = sprintf('%.2f', $value);
            	break;
            case 'cpu': // For PPC arch (damn borked POS)
            	$results['model'] = $value;
            	break;
            case 'L2 cache': // More for PPC
            	$results['cache'] = $value;
            	break;
            case 'revision': // For PPC arch (damn borked POS)
            	$results['model'] .= ' ( rev: ' . $value . ')';
            	break;
            case 'cpu model': // For Alpha arch - 2.2.x
            	$results['model'] .= ' (' . $value . ')';
            	break;
            case 'cache size':
            	$results['cache'] = $value;
            	break;
            case 'bogomips':
            	$results['bogomips'] += $value;
            	break;
            case 'BogoMIPS': // For alpha arch - 2.2.x
            	$results['bogomips'] += $value;
            	break;
            case 'BogoMips': // For sparc arch
            	$results['bogomips'] += $value;
            	break;
            case 'cpus detected': // For Alpha arch - 2.2.x
            	$results['cpus'] += $value;
            	break;
            case 'system type': // Alpha arch - 2.2.x
            	$results['model'] .= ', ' . $value . ' ';
            	break;
            case 'platform string': // Alpha arch - 2.2.x
            	$results['model'] .= ' (' . $value . ')';
            	break;
            case 'processor':
            	$results['cpus'] += 1;
            	break;
            case 'Cpu0ClkTck': // Linux sparc64
            	$results['cpuspeed'] = sprintf('%.2f', hexdec($value) / 1000000);
            	break;
            case 'Cpu0Bogo': // Linux sparc64 & sparc32
            	$results['bogomips'] = $value;
            	break;
            case 'ncpus probed': // Linux sparc64 & sparc32
            	$results['cpus'] = $value;
            	break;
              }
        	}
        }

        $sparclist = array('SUNW,UltraSPARC@0,0', 'SUNW,UltraSPARC-II@0,0', 'SUNW,UltraSPARC@1c,0', 'SUNW,UltraSPARC-IIi@1c,0', 'SUNW,UltraSPARC-II@1c,0', 'SUNW,UltraSPARC-IIe@0,0');
        foreach ($sparclist as $name) {
          $buf = rfts( '/proc/openprom/' . $name . '/ecache-size',1 , 32, false );
          if( $buf != "ERROR" ) {
            $results['cache'] = base_convert($buf, 16, 10)/1024 . ' KB';
          }
        }

        if ( $results['cpus'] == 0 ) {
          foreach( $bufe as $buf ) {
            $fields = preg_split('/\s*:\s*/', trim($buf), 2);
            if (sizeof($fields) == 2) {
              list($key, $value) = $fields;
              switch($key) {
                case 'Processor':
                  $results['cpus'] += 1;
                  $results['model'] = $value;
                  break;
                case 'BogoMIPS':
                  $results['cpuspeed'] = $value;
                  break;
                case 'I size':
                  $results['cache'] = $value;
                  break;
                case 'D size':
                  $results['cache'] += $value;
                  break;
              }
            }
          }
          $results['cache'] = $results['cache'] / 1024 . " KB";
        }
      }
      $keys = array_keys($results);
      $keys2be = array('model', 'cpuspeed', 'cache', 'bogomips', 'cpus');
		
      while ($ar_buf = each($keys2be)) {
        if (! in_array($ar_buf[1], $keys)) {
          $results[$ar_buf[1]] = 'N.A.';
        } 
      }
		
      $buf = rfts( '/proc/acpi/thermal_zone/THRM/temperature', 1, 4096, false );
      if ( $buf != "ERROR" ) {
        $results['temp'] = substr( $buf, 25, 2 );
      }

      return $results;

  	}

    public function pci () {
      $arrResults = array();
      $booDevice = false;

      if( ! $arrResults = $this->parser->parse_lspci() ) {
        $strBuf = rfts( '/proc/pci', 0, 4096, false );
        if( $strBuf != "ERROR" ) {
          $arrBuf = explode( "\n", $strBuf );
          foreach( $arrBuf as $strLine ) {
            if( preg_match( '/Bus/', $strLine ) ) {
              $booDevice = true;
              continue;
            }
            if( $booDevice ) {
              list( $strKey, $strValue ) = split( ': ', $strLine, 2 );
              if( ! preg_match( '/bridge/i', $strKey ) && ! preg_match( '/USB/i ', $strKey ) ) {
                $arrResults[] = preg_replace( '/\([^\)]+\)\.$/', '', trim( $strValue ) );
              }
              $booDevice = false;
            }
          }
          asort( $arrResults );
        }
      }
      return $arrResults;

    }

    public function ide () {
      $results = array();
      $bufd = gdc( '/proc/ide', false );
    
      foreach( $bufd as $file ) {
        if (preg_match('/^hd/', $file)) {
          $results[$file] = array(); 
          $buf = rfts("/proc/ide/" . $file . "/media", 1 );
          if ( $buf != "ERROR" ) {
            $results[$file]['media'] = trim($buf);
            if ($results[$file]['media'] == 'disk') {
              $results[$file]['media'] = 'Hard Disk';
              $buf = rfts( "/proc/ide/" . $file . "/capacity", 1, 4096, false);
              if( $buf == "ERROR" ) {
                $buf = rfts( "/sys/block/" . $file . "/size", 1, 4096, false);
              }
              if ( $buf != "ERROR" ) {
                $results[$file]['capacity'] = trim( $buf );
              }
            } elseif ($results[$file]['media'] == 'cdrom') {
              $results[$file]['media'] = 'CD-ROM';
              unset($results[$file]['capacity']);
            }
          } else {
            unset($results[$file]);
          }

          $buf = rfts( "/proc/ide/" . $file . "/model", 1 );
          if ( $buf != "ERROR" ) {
            $results[$file]['model'] = trim( $buf );
            if (preg_match('/WDC/', $results[$file]['model'])) {
              $results[$file]['manufacture'] = 'Western Digital';
            } elseif (preg_match('/IBM/', $results[$file]['model'])) {
              $results[$file]['manufacture'] = 'IBM';
            } elseif (preg_match('/FUJITSU/', $results[$file]['model'])) {
              $results[$file]['manufacture'] = 'Fujitsu';
            } else {
              $results[$file]['manufacture'] = 'Unknown';
            }
          }
        }
      }
    
      asort($results);
      return $results;
    
    }

    public function scsi () {
      $results = array();
      $dev_vendor = '';
      $dev_model = '';
      $dev_rev = '';
      $dev_type = '';
      $s = 1;
      $get_type = 0;

      $bufr = execute_program('lsscsi', '-c', false);
      if( $bufr == "ERROR" ) {
      $bufr = rfts( '/proc/scsi/scsi', 0, 4096, false);
      }
      if ( $bufr != "ERROR" ) {
        $bufe = explode("\n", $bufr);
        foreach( $bufe as $buf ) {
          if (preg_match('/Vendor/', $buf)) {
            preg_match('/Vendor: (.*) Model: (.*) Rev: (.*)/i', $buf, $dev);
            list($key, $value) = split(': ', $buf, 2);
            $dev_str = $value;
            $get_type = true;
            continue;
          } 

          if ($get_type) {
            preg_match('/Type:\s+(\S+)/i', $buf, $dev_type);
            $results[$s]['model'] = "$dev[1] $dev[2] ($dev_type[1])";
            $results[$s]['media'] = "Hard Disk";
            $s++;
            $get_type = false;
          }
        }
      }
      asort($results);
      return $results;

    }

    public function usb () {
      $results = array();
      $devnum = -1;

      $bufr = execute_program('lsusb', '', false);
      if( $bufr == "ERROR" ) {
	      $bufr = rfts( '/proc/bus/usb/devices', 0, 4096, false );
        if ( $bufr != "ERROR" ) {
    	    $bufe = explode("\n", $bufr);
	        foreach( $bufe as $buf ) {
        	  if (preg_match('/^T/', $buf)) {
              $devnum += 1;
              $results[$devnum] = "";
            } elseif (preg_match('/^S:/', $buf)) {
              list($key, $value) = split(': ', $buf, 2);
              list($key, $value2) = split('=', $value, 2);
              if (trim($key) != "SerialNumber") {
                $results[$devnum] .= " " . trim($value2);
                $devstring = 0;
              }
            }
          }
        } 
      } else {
        $bufe = explode( "\n", $bufr );
        foreach( $bufe as $buf ) {
          $device = preg_split("/ /", $buf, 7);
          if( isset( $device[6] ) && trim( $device[6] ) != "" ) {
            $results[$devnum++] = trim( $device[6] );
          }
        }
      }
      return $results;

    } 

    public function sbus () {

      $results = array();
      $_results[0] = ""; 
      // TODO. Nothing here yet. Move along.
      $results = $_results;
      return $results;

    }

    public function network () {
      $results = array();

      $bufr = rfts( '/proc/net/dev' );
      if ( $bufr != "ERROR" ) {
        $bufe = explode("\n", $bufr);
        foreach( $bufe as $buf ) {
          if (preg_match('/:/', $buf)) {
            list($dev_name, $stats_list) = preg_split('/:/', $buf, 2);
            $stats = preg_split('/\s+/', trim($stats_list));
            $results[$dev_name] = array();

            $results[$dev_name]['rx_bytes'] = $stats[0];
            $results[$dev_name]['rx_packets'] = $stats[1];
            $results[$dev_name]['rx_errs'] = $stats[2];
            $results[$dev_name]['rx_drop'] = $stats[3];

            $results[$dev_name]['tx_bytes'] = $stats[8];
            $results[$dev_name]['tx_packets'] = $stats[9];
            $results[$dev_name]['tx_errs'] = $stats[10];
            $results[$dev_name]['tx_drop'] = $stats[11];

            $results[$dev_name]['errs'] = $stats[2] + $stats[10];
            $results[$dev_name]['drop'] = $stats[3] + $stats[11];
          } 
        }
      }
      return $results;

    } 

    public function memory () {
      $results['ram'] = array('total' => 0, 'free' => 0, 'used' => 0, 'percent' => 0);
      $results['swap'] = array('total' => 0, 'free' => 0, 'used' => 0, 'percent' => 0);
      $results['devswap'] = array();

      $bufr = rfts( '/proc/meminfo' );
      if ( $bufr != "ERROR" ) {
        $bufe = explode("\n", $bufr);
        foreach( $bufe as $buf ) {
          if (preg_match('/^MemTotal:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
            $results['ram']['total'] = $ar_buf[1];
          } else if (preg_match('/^MemFree:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
            $results['ram']['free'] = $ar_buf[1];
          } else if (preg_match('/^Cached:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
            $results['ram']['cached'] = $ar_buf[1];
          } else if (preg_match('/^Buffers:\s+(.*)\s*kB/i', $buf, $ar_buf)) {
            $results['ram']['buffers'] = $ar_buf[1];
          }
        }

        $results['ram']['used'] = $results['ram']['total'] - $results['ram']['free'];
        $results['ram']['percent'] = round(($results['ram']['used'] * 100) / $results['ram']['total']);

        if (isset($results['ram']['cached']) && isset($results['ram']['buffers'])) {
          $results['ram']['app'] = $results['ram']['used'] - $results['ram']['cached'] - $results['ram']['buffers'];
        	$results['ram']['app_percent'] = round(($results['ram']['app'] * 100) / $results['ram']['total']);
        	$results['ram']['buffers_percent'] = round(($results['ram']['buffers'] * 100) / $results['ram']['total']);
        	$results['ram']['cached_percent'] = round(($results['ram']['cached'] * 100) / $results['ram']['total']);
        }

        $bufr = rfts( '/proc/swaps' );
        if ( $bufr != "ERROR" ) {
          $swaps = explode("\n", $bufr);
          for ($i = 1; $i < (sizeof($swaps)); $i++) {
  	        if( trim( $swaps[$i] ) != "" ) {
              $ar_buf = preg_split('/\s+/', $swaps[$i], 6);
              $results['devswap'][$i - 1] = array();
              $results['devswap'][$i - 1]['dev'] = $ar_buf[0];
              $results['devswap'][$i - 1]['total'] = $ar_buf[2];
              $results['devswap'][$i - 1]['used'] = $ar_buf[3];
              $results['devswap'][$i - 1]['free'] = ($results['devswap'][$i - 1]['total'] - $results['devswap'][$i - 1]['used']);
              $results['devswap'][$i - 1]['percent'] = round(($ar_buf[3] * 100) / $ar_buf[2]);
        	    $results['swap']['total'] += $ar_buf[2];
        	    $results['swap']['used'] += $ar_buf[3];
        	    $results['swap']['free'] = $results['swap']['total'] - $results['swap']['used'];
        	    $results['swap']['percent'] = round(($results['swap']['used'] * 100) / $results['swap']['total']);
        	  }
          } 
        }
      }
      return $results;

    } 
  
    public function filesystems () {

      return $this->parser->parse_filesystems();

    } 

    public function distro () {

     return $this->distro;

    }

    public function distroicon () {   

     return $this->icon;

    }

} 

?>
