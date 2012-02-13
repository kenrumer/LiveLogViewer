<?php

  class backend_config {

    private $variables;

    public function backend_config() {

      $this->comments = array(";", "#");
      $this->group_start = array("[");
      $this->group_end = array("]");

      $this->variables = array();

    }

    public function get($variable, $group="none") {

      if (isset($this->variables[$group][$variable])) {
        return $this->variables[$group][$variable];
      }
      return FALSE;

    }

    public function set($variable, $group, $value) {

      $this->variables[$group][$variable] = $value;

    }

    public function read_config() {

      $group = "none";
      $write_config = FALSE;
      $fp = fopen(getenv("ASC_HOME")."/etc/asc.conf", "rb");
      while (!feof($fp)) {
        $line = trim(fgets($fp));
        if ($line && !in_array(substr($line, 0, 1), $this->comments)) {
          if (in_array(substr($line, 0, 1), $this->group_start) && in_array(substr($line, -1), $this->group_end)) {
            foreach ($this->group_start as $start) {
              $line = trim($line, $start);
            }
            foreach ($this->group_end as $end) {
              $line = trim($line, $end);
            }
            $group = trim($line);
          } else {
            $pieces = explode("=", $line, 2);
            $option = trim($pieces[0], "\"");
            $value = trim($pieces[1], "\"");
            $option = trim($option);
            $value = trim($value);
            if (substr($value, 0, 11) == '(encrypted)') {
              $value = trim($value , '(encrypted)');
              $value = $this->decrypt($value);
            }
            $this->set($option, $group, $value);
          }
        }
      }
      fclose($fp);

    }

  }

?>
