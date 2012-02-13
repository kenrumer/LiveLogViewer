<?php

  class ldap {

    private $connection;

    public function ldap($session) {

      $this->session = $session;

    }

    public function connect() {

      $this->connection = ldap_connect($this->session->get("hostname", "ldap"));
      if (!$this->connection) {
        return FALSE;
      }

      ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);

      return TRUE;

    }

    public function bind() {

      $bind = ldap_bind($this->connection, $this->session->get("bind_dn", "ldap"), $this->session->get("passwd", "ldap"));
      if (!$bind) {
        return FALSE;
      }

      return TRUE;

    }

    public function search($user_name) {

      return ldap_search ($this->connection, $this->session->get("base_dn", "ldap"), "(".$this->session->get("filter", "ldap")."=".$user_name.")");

    }

    public function get_dn($result) {

      $entries = ldap_get_entries($this->connection, $result);
      if ($entries["count"] != 1) {
        return FALSE;
      }

      return $entries[0]["dn"];

    }

    public function get_attributes($result) {

      $entries = ldap_get_entries($this->connection, $result);
      return $entries[0];

    }

    public function login($dn, $passwd) {

      $bind = ldap_bind($this->connection, $dn, $passwd);
      if (!$bind) {
        return FALSE;
      }

      return TRUE;

    }

    public function close() {

      ldap_unbind($this->connection);

    }

  }
