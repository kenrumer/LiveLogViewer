<?php

  class common {

    private $m_strHostname;
    private $m_strFrontend_server;

    public function common() {

      $script_name = $_SERVER['SCRIPT_NAME'];
      $this->m_strHostname = substr($script_name, 1, strpos($script_name, "/", 1) - 1);
      $this->m_strFrontend_Server = $_SERVER['SERVER_NAME'];

    }

    public function print_header() {

      header("Expires: " . gmstrftime("%a, %d %b %Y %H:%M:%S GMT"));
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");

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

    public function find_program ($strProgram, $addpaths = null) {

      $arrPath = array( '/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin' );
      if( isset( $addpaths ) && is_array( $addpaths ) ) {
        $arrPath = array_merge( $arrPath, $addpaths );
      }
      if ( function_exists( "is_executable" ) ) {
        foreach ( $arrPath as $strPath ) {
          $strProgrammpath = $strPath . "/" . $strProgram;
          if( is_executable( $strProgrammpath ) ) {
            return $strProgrammpath;
          }
        }
      } else {
        return strpos( $strProgram, '.exe' );
      }

    }

    public function execute_program ($strProgramname, $strArgs = '', $booErrorRep = true ) {
      $strBuffer = '';
      $strError = '';

      $strProgram = $this->find_program($strProgramname);
      if ( ! $strProgram ) {
        return "ERROR";
      }
      if( $strArgs ) {
        $arrArgs = explode(' ', $strArgs );
        for( $i = 0; $i < count( $arrArgs ); $i++ ) {
          if ( $arrArgs[$i] == '|' ) {
            $strCmd = $arrArgs[$i + 1];
            $strNewcmd = $this->find_program( $strCmd );
            $strArgs = str_replace("| ".$strCmd, "| ".$strNewcmd, $strArgs);
          }
        }
      }
      if( function_exists( 'proc_open' ) ) {
        $descriptorspec = array(
          0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
          1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
          2 => array("pipe", "w")   // stderr is a pipe that the child will write to
        );
        $process = proc_open( $strProgram . " " . $strArgs, $descriptorspec, $pipes );
        if( is_resource( $process ) ) {
          while( !feof( $pipes[1] ) ) {
            $strBuffer .= fgets( $pipes[1], 1024 );
          }
          fclose( $pipes[1] );
          while( !feof( $pipes[2] ) ) {
            $strError .= fgets( $pipes[2], 1024 );
          }
          fclose( $pipes[2] );
        }
        $return_value = proc_close( $process );
      } else {
        if( $fp = popen( "(" . $strProgram . " " . $strArgs . " > /dev/null) 3>&1 1>&2 2>&3", 'r' ) ) {
          while( ! feof( $fp ) ) {
            $strError .= fgets( $fp, 4096 );
          }
          pclose( $fp );
        }
        $strError = trim( $strError );
        if( $fp = popen( $strProgram . " " . $strArgs, 'r' ) ) {
          while( ! feof( $fp ) ) {
            $strBuffer .= fgets( $fp, 4096 );
          }
          $return_value = pclose( $fp );
        }
      }

      $strError = trim( $strError );
      $strBuffer = trim( $strBuffer );

      return $strBuffer;
    }

    public function get_hostname() {

      return $this->m_strHostname;

    }

    public function get_frontend_server() {

      return $this->m_strFrontend_server;

    }

    public function get_query_string($get, $strVar, $required=TRUE) {

      if (isset($get[$strVar])) {
        return $get[$strVar];
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

    public function make_temp_dir() {

      $temp_dir = sys_get_temp_dir();
      $new_dir = $temp_dir.md5(uniqid(rand(), true));
      mkdir($new_dir, 0755);

      return $new_dir;

    }

    public function get_url_contents($url, $path, $file_name) {

      if ($path == "") {
        $path = sys_get_temp_dir();
      }
      if ($file_name == "") {
        echo "get_url_contents: file_name not set";
        return FALSE;
      }
      if (!copy($url, $path."/".$file_name)) {
        echo ("get_url_contents: Failed to copy file - $file_name");
        return FALSE;
      }

      return $path."/".$file_name;

    }

    public function get_file_extension($file_name) {

      $file_extension = substr(strrchr($file_name, '.'), 1);
      return $file_extension;

    }

    public function getopt($args, $short_options, $long_options = null) {

      $opts     = array();
      $non_opts = array();

      if ($long_options) {
        sort($long_options);
      }

      reset($args);
      while (list($i, $arg) = each($args)) {
        if ($arg == '--') {
          $non_opts = array_merge($non_opts, array_slice($args, $i + 1));
        }
        if ($arg[0] != '-' || (strlen($arg) > 1 && $arg[1] == '-' && !$long_options)) {
          $log_name = $arg;
          echo ("log_name=\"".$log_name."\"");
        } elseif (strlen($arg) > 1 && $arg[1] == '-') {
          $this->_parseLongOption(substr($arg, 2), $long_options, $opts[$log_name], $args);
        } else {
          $this->_parseShortOption(substr($arg, 1), $short_options, $opts[$log_name], $args);
        }
      }
      return $opts;
  
    }
    
    public function _parseShortOption($arg, $short_options, &$opts, &$args) {

      for ($i = 0; $i < strlen($arg); $i++) {
        $opt = $arg{$i};
        $opt_arg = null;

        if (($spec = strstr($short_options, $opt)) === false || $arg{$i} == ':') {
          return;
        }

        if (strlen($spec) > 1 && $spec{1} == ':') {
          if (strlen($spec) > 2 && $spec{2} == ':') {
            if ($i + 1 < strlen($arg)) {
              $opts[$opt] = substr($arg, $i + 1);
              break;
            }
          } else {
            if ($i + 1 < strlen($arg)) {
      echo "spec=\"".$spec."\"";
              $opts[$opt] = substr($arg, $i + 1);
              break;
            }
          }
        }
        $opts[$opt] = $opt_arg;
      }

    }

    public function _parseLongOption($arg, $long_options, &$opts, &$args)
    {
      echo "arg_long=\"".$arg."\"";
      @list($opt, $opt_arg) = explode('=', $arg, 2);
      $opt_len = strlen($opt);

      for ($i = 0; $i < count($long_options); $i++) {
        $long_opt  = $long_options[$i];
        $opt_start = substr($long_opt, 0, $opt_len);

        if ($opt_start != $opt) {
          continue;
        }

        $opt_rest  = substr($long_opt, $opt_len);

        if ($opt_rest != '' && $opt{0} != '=' && $i + 1 < count($long_options) && $opt == substr($long_options[$i+1], 0, $opt_len)) {
          return;
        }

        if (substr($long_opt, -1) == '=') {
          if (substr($long_opt, -2) != '==') {
            if (!strlen($opt_arg) && !(list(, $opt_arg) = each($args))) {
              return;
            }
          }
        } else if ($opt_arg) {
          return;
        }

        $opts[] = array('--' . $opt, $opt_arg);
        return;
      }
      return false;

    }

  }

?>
