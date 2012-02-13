<?php
  $debug = false; // set this to true to see useful info in error_log
  $self = $_SERVER['PHP_SELF'];

  header("Expires: " . gmstrftime("%a, %d %b %Y %H:%M:%S GMT"));
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  $script_name = $_SERVER['SCRIPT_NAME'];
  $hostname = substr($script_name, 1, strpos($script_name, "/", 1) - 1);
  $frontend_server = $_SERVER['SERVER_NAME'];
  $limit = 512 * 1024;

  function get_application_servers($application) {
    global $debug, $self;
    if ($debug) error_log("$self(get_application_servers): Passed parameter: $application", 0);

    $ret_array = array();
    $ret_array['envlog01.idc1.level3.com'] = '/app/asc';
    return $ret_array;

  }

  function get_files($path) {
    global $debug, $self;
    if ($debug) error_log("$self(get_files): Passed parameter: $path", 0);

    $ret_array = array();

    $dh = opendir($path);
    while (false !== ($name = readdir($dh))) {
      if (is_file($path.'/'.$name)) {
        $attribs = stat($path.'/'.$name);
        $ret_array[$name] = array();
        $ret_array[$name]['size'] = $attribs['size'];
        $ret_array[$name]['mtime'] = $attribs['mtime'];
        $ret_array[$name]['md5'] = md5_file($path.'/'.$name);
      }
    }
    closedir($dh);
    return $ret_array;

  }

  function get_sub_dirs($path) {
    global $debug, $self;
    if ($debug) error_log("$self(get_sub_dirs): Passed parameter: $path", 0);

    $ret_array = array();

    $dh = opendir($path);
    while (false !== ($name = readdir($dh))) {
      if ($name !== '.' && $name !== '..' && is_dir($path.'/'.$name)) {
        $ret_array[] = $name;
      }
    }

    natcasesort($ret_array);

    return $ret_array;

  }

  function has_subdir($path) {
    global $debug, $self;
    if ($debug) error_log("$self(has_subdir): Passed parameter: $path", 0);

    $dh = opendir($path);
    while (false !== ($name = readdir($dh))) {
      if (!($name == ".") && !($name == "..") && is_dir($path."/".$name)) {
        return true;
      }
    }
    return false;

  }


  function delete_dir($dir) {
    global $debug, $self;
    if ($debug) error_log("$self(delete_dir): Passed parameter: $dir", 0);

    $mydir = opendir($dir);
    while(false !== ($file = readdir($mydir))) {
      if($file != "." && $file != ".." && $file != "deployer.php" && !is_dir($dir.$file)) {
        unlink($dir."/".$file);
      }
    }
    closedir($mydir);

  }

  function byte_convert($bytes) {
    global $debug, $self;
    if ($debug) error_log("$self(byte_convert): Passed parameter: $bytes", 0);

    $symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $exp = 0;
    $converted_value = 0;
    if( $bytes > 0 )
    {
      $exp = floor( log($bytes)/log(1024) );
      $converted_value = ( $bytes/pow(1024,floor($exp)) );
    }
    return sprintf( '%.2f'.$symbol[$exp], $converted_value );

  }

  function is_empty_dir($dir) {
    global $debug, $self;
    if ($debug) error_log("$self(is_empty_dir): Passed parameter: $dir", 0);

    $files = array();
    if (is_dir($dir)) {
      $dh = opendir($dir);
      while (false !== ($filename = readdir($dh))) {
        if (!($filename == ".") && !($filename == "..") && is_dir($dir."/".$filename)) {
          return true;
        }
      }
      return false;
    } else {
      return false;
    }

  }

  function getRequiredQueryString($get, $strVar) {
    global $debug, $self;
    if ($debug) error_log("$self(getRequiredQueryString): Passed parameters: dir=var_export($get), strVar=$strVar", 0);

    if (isset($get[$strVar])) {
      return $get[$strVar];
    } else {
      echo("$strVar variable not set\n");
      exit(-1);
    }

  }

  function getQueryString($get, $strVar) {
    global $debug, $self;
    if ($debug) error_log("$self(getQueryString): Passed parameters: dir=var_export($get), strVar=$strVar", 0);

    if (isset($get[$strVar])) {
      return $get[$strVar];
    }

  }

  function getRequiredPostString($post, $strVar) {
    global $debug, $self;
    if ($debug) error_log("$self(getRequiredPostString): Passed parameters: dir=var_export($post), strVar=$strVar", 0);

    if (isset($post[$strVar])) {
      return $post[$strVar];
    } else {
      echo("$strVar variable not set\n");
      exit(-1);
    }

  }

  function getPostString($post, $strVar) {
    global $debug, $self;
    if ($debug) error_log("$self(getPostString): Passed parameters: dir=var_export($post), strVar=$strVar", 0);

    if (isset($post[$strVar])) {
      return $post[$strVar];
    }

  }

  if (isset($_HIDDENDIRS)) {
    if (in_array($path, $_HIDDENDIRS)) {
      echo("Unable to access hidden directories\n");
      exit(-1);
    }
  }

  if (isset($_HIDDENFILES)) {
    if (in_array($path, $_HIDDENFILE)) {
      echo("Unable to access hidden files\n");
      exit(-1);
    }
  }

?>
