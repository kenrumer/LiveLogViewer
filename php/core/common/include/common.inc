<?php

  class common {

    private $script_name;
    private $hostname;
    private $frontend_server;

    public function common () {

      $this->script_name = $_SERVER['SCRIPT_NAME'];
      //$this->hostname = substr($this->script_name, 1, strpos($this->script_name, "/", 1) - 1);
      $this->frontend_server = $_SERVER['SERVER_NAME'];

    }

    public function find_in_array ($string, $array = array ()) {

      foreach ($array as $key => $value) {
        unset ($array[$key]);
        if (strpos($value, $string) !== false) {
          return TRUE;
        }
      }
      return FALSE;

    }

    public function print_header() {

      header("Expires: " . gmstrftime("%a, %d %b %Y %H:%M:%S GMT"));
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");

    }

    public function byte_convert($bytes) {

      $symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
      $exp = 0;
      $converted_value = 0;
      if ($bytes > 0)
      {
        $exp = floor( log($bytes)/log(1024) );
        $converted_value = ( $bytes/pow(1024,floor($exp)) );
      }
      return sprintf( '%.2f'.$symbol[$exp], $converted_value );

    }

    public function get_query_string($get, $strVar, $required=TRUE) {

      if (isset($get[$strVar])) {
        return urldecode($get[$strVar]);
      } else if ($required) {
        echo("$strVar variable not set\n");
        exit(-1);
      }

      return FALSE;

    }

    public function get_post_string($post, $strVar, $required=TRUE) {

      if (isset($post[$strVar])) {
        return $post[$strVar];
      } else if ($required) {
        echo("$strVar variable not set\n");
        exit(-1);
      }

      return FALSE;

    }

    public function create_bargraph ($value, $maximum, $b, $type = "") {
    
      $imgpath = "/common/images/";
      if ($maximum > 0) {
        $barwidth = round((100  / $maximum) * $value) * $b;
      } else {
        $barwidth = 0;
      }
      $red = 90 * $b;
      if (( $barwidth < $red ) || ( $type == "iso9660" ) || ( $type == "CDFS" )) {
        return '<img height="16" alt="" src="/common/images/bar_left.gif">'
          .'<img height="16" alt="" src="/common/images/bar_middle.gif" width="' . $barwidth . '">'
          .'<img height="16" alt="" src="/common/images/nobar_middle.gif" width="' . ( ( 100 * $b ) - $barwidth ) . '">'
          .'<img height="16" alt="" src="/common/images/nobar_right.gif">';
      } elseif ($barwidth == ( 100 * $b )) {
        return '<img height="16" alt="" src="/common/images/redbar_left.gif">'
          .'<img height="16" alt="" src="/common/images/redbar_middle.gif" width="' . ( 100 * $b ) . '">'
          .'<img height="16" alt="" src="/common/images/redbar_right.gif">';
      } else {
        return '<img height="16" alt="" src="/common/images/redbar_left.gif">'
          .'<img height="16" alt="" src="/common/images/redbar_middle.gif" width="' . $barwidth . '">'
          .'<img height="16" alt="" src="/common/images/nobar_middle.gif" width="' . ( ( 100 * $b ) - $barwidth ) . '">'
          .'<img height="16" alt="" src="/common/images/nobar_right.gif">';
      }

    }

    public function format_speed( $intHz ) {
      $strResult = "";
 
      if( $intHz < 1000 ) {
        $strResult = $intHz . " Mhz";
      } else {
        $strResult = round( $intHz / 1000, 2 ) . " GHz";
      }
 
      return $strResult;

    }

    public function format_bytesize ($intKbytes, $intDecplaces = 2) {
 
      if( $intKbytes > 1048576 ) {
        $strResult = sprintf( '%.' . $intDecplaces . 'f', $intKbytes / 1048576 );
        $strResult .= "&nbsp;GB";
      } elseif( $intKbytes > 1024 ) {
        $strResult = sprintf( '%.' . $intDecplaces . 'f', $intKbytes / 1024);
        $strResult .= "&nbsp;MB";
      } else {
        $strResult = sprintf( '%.' . $intDecplaces . 'f', $intKbytes );
        $strResult .= "&nbsp;KB";
      }
 
      return $strResult;
 
    }

    public function format_time( $intTimestamp ) {

      $strUptime = '';
 
      $intMin = $intTimestamp / 60;
      $intHours = $intMin / 60;
      $intDays = floor( $intHours / 24 );
      $intHours = floor( $intHours - ( $intDays * 24 ) );
      $intMin = floor( $intMin - ( $intDays * 60 * 24 ) - ( $intHours * 60 ) );
 
      if( $intDays != 0 ) {
        $strUptime .= $intDays. "&nbsp;days&nbsp;";
      }
      if( $intHours != 0 ) {
        $strUptime .= $intHours . "&nbsp;hours&nbsp;";
      }
      $strUptime .= $intMin . "&nbsp;minutes";

      return $strUptime;

    }

    public function add_server_to_web_server($fqdn, $primary_ip, $os_type) {

      $fh = fopen(getenv("ASC_HOME")."/etc/core.lighttpd.ini", "r");
      $contents = fread($fh, filesize(getenv("ASC_HOME")."/etc/core.lighttpd.ini"));
      fclose($fh);
      $fh = fopen(getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini", "r");
      $contents2 = fread($fh, filesize(getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini"));
      fclose($fh);
      if (strpos($contents, $fqdn) !== FALSE) {
        return FALSE;
      }
      if ($os_type == "unix") {
        $contents = str_replace("##INSERT_FASTCGI_ABOVE##", "                    \"/$fqdn/\" =>\n                   ( \"$fqdn\" => (\n                       \"host\" => \"$primary_ip\",\n                       \"port\" => 7871,\n                       \"check-local\" => \"disable\",\n                       \"docroot\" => \"/app/asc/node/docroot/\",\n                       \"broken-scriptfilename\" => \"enable\"\n                   ) ),\n##INSERT_FASTCGI_ABOVE##", $contents);
        $contents2 = str_replace("##INSERT_FASTCGI_ABOVE##", "                    \"/$fqdn/\" =>\n                   ( \"$fqdn\" => (\n                       \"host\" => \"$primary_ip\",\n                       \"port\" => 7871,\n                       \"check-local\" => \"disable\",\n                       \"docroot\" => \"/app/asc/node/docroot/\",\n                       \"broken-scriptfilename\" => \"enable\"\n                   ) ),\n##INSERT_FASTCGI_ABOVE##", $contents2);
      } else {
        $contents = str_replace("##INSERT_FASTCGI_ABOVE##", "                    \"/$fqdn/\" =>\n                   ( \"$fqdn\" => (\n                       \"host\" => \"$primary_ip\",\n                       \"port\" => 7871,\n                       \"check-local\" => \"disable\",\n                       \"docroot\" => \"C:/Program Files/PHP/node/docroot/\",\n                       \"broken-scriptfilename\" => \"enable\"\n                   ) ),\n##INSERT_FASTCGI_ABOVE##", $contents);
        $contents2 = str_replace("##INSERT_FASTCGI_ABOVE##", "                    \"/$fqdn/\" =>\n                   ( \"$fqdn\" => (\n                       \"host\" => \"$primary_ip\",\n                       \"port\" => 7871,\n                       \"check-local\" => \"disable\",\n                       \"docroot\" => \"C:/Program Files/PHP/node/docroot/\",\n                       \"broken-scriptfilename\" => \"enable\"\n                   ) ),\n##INSERT_FASTCGI_ABOVE##", $contents2);
      }
      $contents = str_replace("##INSERT_AUTH_ABOVE##", "                               \"/$fqdn/\" =>\n                               (\n                                 \"method\"  => \"basic\",\n                                 \"realm\"   => \"Backend Admin Only\",\n                                 \"require\" => \"valid-user\"\n                               ),\n##INSERT_AUTH_ABOVE##", $contents);
      $contents2 = str_replace("##INSERT_AUTH_ABOVE##", "                               \"/$fqdn/\" =>\n                               (\n                                 \"method\"  => \"basic\",\n                                 \"realm\"   => \"Backend Admin Only\",\n                                 \"require\" => \"valid-user\"\n                               ),\n##INSERT_AUTH_ABOVE##", $contents2);
      copy(getenv("ASC_HOME")."/etc/core.lighttpd.ini", getenv("ASC_HOME")."/etc/core.lighttpd.ini.bak".date("YmdGis"));
      copy(getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini", getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini.bak".date("YmdGis"));
      unlink(getenv("ASC_HOME")."/etc/core.lighttpd.ini");
      unlink(getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini");
      $fh = fopen(getenv("ASC_HOME")."/etc/core.lighttpd.ini", "w");
      fwrite($fh, $contents);
      fclose($fh);
      $fh = fopen(getenv("ASC_HOME")."/etc/core.lighttpd-multiple_ports.ini", "w");
      fwrite($fh, $contents2);
      fclose($fh);
      return TRUE;

    }

    public function restart_web_server() {

      system(getenv("ASC_HOME")."/bin/lighttpd.restart");
      return TRUE;

    }

  }

?>
