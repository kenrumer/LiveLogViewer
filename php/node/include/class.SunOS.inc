<?php 

  include_once ("common.inc");

  class sysinfo {

    private $c_common;

    public function sysinfo () {

      $this->c_common = new common();

    }

    public function kstat ($key) {

      $m = $this->c_common->execute_program('kstat', "-p d $key");
      if (trim($m) != "") {
        list($key, $value) = split("\t", trim($m), 2);
        return $value;
      } else {
        return "";
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

      if ($result = $this->c_common->execute_program('uname', '-n')) {
        $result = gethostbyaddr(gethostbyname($result));
      } else {
        $result = 'N.A.';
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

      $os = $this->c_common->execute_program('uname', '-s');
      $version = $this->c_common->execute_program('uname', '-r');
      return $os . ' ' . $version;

    } 
  
    public function uptime () {

      $result = time() - $this->kstat('unix:0:system_misc:boot_time');
  
      return $result;

    } 
  
    public function users () {

      $who = split('=', $this->c_common->execute_program('who', '-q'));
      $result = $who[1];
      return $result;

    } 
  
    public function loadavg ($bar = false) {

      $load1 = $this->kstat('unix:0:system_misc:avenrun_1min');
      $load5 = $this->kstat('unix:0:system_misc:avenrun_5min');
      $load15 = $this->kstat('unix:0:system_misc:avenrun_15min');
      $results['avg'] = array( round($load1/256, 2), round($load5/256, 2), round($load15/256, 2) );
      return $results;

    }
  
    public function cpu_info () {
      $results = array();
      $ar_buf = array();
  
      $results['model'] = $this->c_common->execute_program('uname', '-i');
      $results['cpuspeed'] = $this->kstat('cpu_info:0:cpu_info0:clock_MHz');
      $results['cache'] = $this->kstat('cpu_info:0:cpu_info0:cpu_type');
      $results['cpus'] = $this->kstat('unix:0:system_misc:ncpus');
  
      return $results;

    } 
  
    public function pci () {

      // FIXME
      $results = array();
      return $results;

    } 
  
    public function ide () {

      // FIXME
      $results = array();
      return $results;

    } 
  
    public function scsi () {

      // FIXME
      $results = array();
      return $results;

    }
  
    public function usb () {
  
      // FIXME
      $results = array();
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
      
      $netstat = $this->c_common->execute_program('netstat', '-ni | awk \'(NF ==10){print;}\'');
      $lines = split("\n", $netstat);
      $results = array();
      for ($i = 0, $max = sizeof($lines); $i < $max; $i++) {
        $ar_buf = preg_split("/\s+/", $lines[$i]);
        if ((!empty($ar_buf[0])) && ($ar_buf[0] != 'Name')) {
          $results[$ar_buf[0]] = array();
          
          $results[$ar_buf[0]]['rx_bytes'] = 0;
          $results[$ar_buf[0]]['rx_packets'] = $ar_buf[4];
          $results[$ar_buf[0]]['rx_errs'] = $ar_buf[5];
          $results[$ar_buf[0]]['rx_drop'] = 0;
          
          $results[$ar_buf[0]]['tx_bytes'] = 0;
          $results[$ar_buf[0]]['tx_packets'] = $ar_buf[6];
          $results[$ar_buf[0]]['tx_errs'] = $ar_buf[7];
          $results[$ar_buf[0]]['tx_drop'] = 0;
          
          $results[$ar_buf[0]]['errs'] = $ar_buf[5] + $ar_buf[
          7];
          $results[$ar_buf[0]]['drop'] = 0;
          
          preg_match('/^(\D+)(\d+)$/', $ar_buf[0], $intf);
          if (isset($intf[1])) {
            $prefix = $intf[1] . ':' . $intf[2] . ':' . $intf[1] . $intf[2] . ':';
          }
          $cnt = $this->kstat($prefix . 'drop');
          
          if ($cnt > 0) {
            $results[$ar_buf[0]]['rx_drop'] = $cnt;
          } 
          $cnt = $this->kstat($prefix . 'obytes64');
          
          if ($cnt > 0) {
            $results[$ar_buf[0]]['tx_bytes'] = $cnt;
          } 
          $cnt = $this->kstat($prefix . 'rbytes64');
          
          if ($cnt > 0) {
            $results[$ar_buf[0]]['rx_bytes'] = $cnt;
          }
        }
      }
      return $results;

    } 
  
    public function memory () {

      $results['devswap'] = array();
      
      $results['ram'] = array();
      
      $pagesize = $this->kstat('unix:0:seg_cache:slab_size');
      $results['ram']['total'] = $this->kstat('unix:0:system_pages:pagestotal') * $pagesize / 1024;
      $results['ram']['used'] = $this->kstat('unix:0:system_pages:pageslocked') * $pagesize / 1024;
      $results['ram']['free'] = $this->kstat('unix:0:system_pages:pagesfree') * $pagesize / 1024;
      $results['ram']['shared'] = 0;
      $results['ram']['buffers'] = 0;
      $results['ram']['cached'] = 0;
      
      $results['ram']['percent'] = round(($results['ram']['used'] * 100) / $results['ram']['total']);
      
      $results['swap'] = array();
      $results['swap']['total'] = $this->kstat('unix:0:vminfo:swap_avail') / 1024 / 1024;
      $results['swap']['used'] = $this->kstat('unix:0:vminfo:swap_alloc') / 1024 / 1024;
      $results['swap']['free'] = $this->kstat('unix:0:vminfo:swap_free') / 1024 / 1024;
      if (isset ($ar_buf[0])) {
        if ($ar_buf[0] > 0) {
          $results['swap']['percent'] = round(($ar_buf[1] * 100) / $ar_buf[0]);
        } else {
          $results['swap']['percent'] = 0;
        }
      }
      $results['swap']['percent'] = round(($results['swap']['used'] * 100) / $results['swap']['total']);
      return $results;

    } 
  
    public function filesystems () {

      $df = $this->c_common->execute_program('df', '-k');
      $mounts = split("\n", $df);
      
      $dftypes = $this->c_common->execute_program('df', '-n');
      $mounttypes = split("\n", $dftypes);
      
      for ($i = 1, $j = 0, $max = sizeof($mounts); $i < $max; $i++) {
        $ar_buf = preg_split('/\s+/', $mounts[$i], 6);
        $ty_buf = split(':', $mounttypes[$i-1], 2);
        
        $results[$j] = array();
        
        $results[$j]['disk'] = $ar_buf[0];
        $results[$j]['size'] = $ar_buf[1];
        $results[$j]['used'] = $ar_buf[2];
        $results[$j]['free'] = $ar_buf[3];
        if ($results[$j]['size'] > 0) {
          $results[$j]['percent'] = round(($results[$j]['used'] * 100) / $results[$j]['size']);
        } else {
          $results[$j]['percent'] = 0;
        }
        $results[$j]['mount'] = $ar_buf[5];
        $results[$j]['fstype'] = $ty_buf[1];
        $j++;
      } 
      return $results;

    } 
  
    public function distro () {

      $result = 'SunOS';  	
      return($result);

    }
  
    public function distroicon () {

      $result = 'SunOS.png';
      return($result);

    }

  } 

?>
