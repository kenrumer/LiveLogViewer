<?php

  class explorer {

    public function explorer() {
    }

    public function create_zip($path, $zip_file, $dir_name) {

      if (is_dir($path)) {
        if ($dh = opendir($path)) {
          while (($file = readdir($dh)) !== false) {
            if (!is_file($path.$file)) {
              if (($file !== ".") && ($file !== "..")) {
                $this->create_zip($path.$file."/", $zip_file, $dir_name.$file."/");
              }
            } else {
              $zip_file->addFile($path.$file, $dir_name.$file);
            }
          }
        }
      } else {
        $zip_file->addFile($path, $dir_name.basename($path));
      }

    }

    public function find_files($path, $depth, $search_file_name, $search_text, $search_date_low, $search_date_high, $size, $search_size_type) {

      $ret_array = array();
      if ($depth > 0) {
        $depth--;
        $dh = opendir($path);
        while (false !== ($file_name = readdir($dh))) {
          if ($file_name != "." && $file_name != "..") {
            if (is_dir($path.$file_name)) {
              $ret_array = array_merge($ret_array, $this->find_files($path.$file_name."/", $depth, $search_file_name, $search_text, $search_date_low, $search_date_high, $size, $search_size_type));
            } else {
              $keep_file = TRUE;
              $count = 0;
              if ($search_file_name) {
                if (!preg_match("/$search_file_name/i", $file_name)) {
                  $keep_file = FALSE;
                }
              }
              if (($size > 0) && ($keep_file)) {
                if ($search_size_type == 0) {
                  if (filesize($path.$file_name) >= $size * 1024) {
                    $keep_file = FALSE;
                  }
                }
                if ($search_size_type == 1) {
                  if (filesize($path.$file_name) <= $size * 1024) {
                    $keep_file = FALSE;
                  }
                }
              }
              if (($search_date_low > 0) && ($keep_file)) {
                if ($search_date_high == 0) {
                  $date1 = time() - ($search_date_low * 24 * 60 * 60);
                  $date2 = filemtime($path.$file_name);
                  if ($date1 >= $date2) {
                    $keep_file = FALSE;
                  }
                } else {
                  $datearr = explode("/", $search_date_low);
                  $date1 = mktime(0, 0, 0, $datearr[0], $datearr[1], $datearr[2]);
                  $date2 = filemtime($path.$file_name);
                  $datearr = explode("/", $search_date_high);
                  $date3 = mktime(0, 0, 0, $datearr[0], $datearr[1], $datearr[2]);
                  if (($date1 >= $date2) || ($date2 >= $date3)) {
                    $keep_file = FALSE;
                  }
                }
              }
              if (($search_text) && ($keep_file)) {
                $fh = @fopen($path.$file_name, 'r');
                if ($fh !== FALSE) {
                  while (!feof($fh)) {
                    if (preg_match_all("/$search_text/i", fread($fh, 1024000), $matches)) {
                      $count += count($matches[0]);
                    }
                  }
                }
                if ($count == 0) {
                  $keep_file = FALSE;
                }
              }
              if ($keep_file) {
                $temp_array = array();
                $temp_array['file_name'] = $path.$file_name;
                $temp_array['count'] = $count;
                $ret_array[] = $temp_array;
              }
            }
          }
        }
      }
      return $ret_array;

    }

    public function has_subcontents($path) {

      $dir_contents = $this->scandir($path);
      if (count($dir_contents) > 0) {
        return true;
      }
      return false;

    }

    public function scandir($path) {

      $ret_array = array();

      if (is_dir($path)) {
        if ($dh = @opendir($path)) {
          while (false !== ($name = readdir($dh))) {
            if ($name !== '.' && $name !== '..') {
              $ret_array[] = $name;
            }
          }
          @closedir($dh);
        }
      }

      natcasesort($ret_array);

      return $ret_array;

    }

    public function get_files($path) {

      $ret_array = array();

      $dir_contents = $this->scandir($path);
      foreach($dir_contents as $content) {
        if (is_file($path.'/'.$content)) {
          $attribs = stat($path.'/'.$content);
          $ret_array[$content] = $attribs;
        } 
      }
      @closedir($dh);
      return $ret_array;

    }

    public function get_directory_contents($path) {

      $ret_array = array();

      $dir_contents = $this->scandir($path);
      foreach($dir_contents as $content) {
        if (is_file($path.'/'.$content)) {
          $attribs = stat($path.'/'.$content);
          $ret_array['files'][$content] = $attribs;
        } else {
          $ret_array['directories'][$content]['has_subcontents'] = $this->has_subcontents($path.'/'.$content);
        } 
      }
      @closedir($dh);
      return $ret_array;

    }


  }

?>
