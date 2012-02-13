<?php

  require_once ("ldap.inc");

  class access {

    private $session;

    public function access($session) {

      $this->session = $session;

    }

    public function is_logged_in() {

      return $this->session->get('logged_in');

    }

    public function login($user_name, $passwd) {

      if (($user_name == "") || ($passwd == "")) {
        header('HTTP/1.1 403 Forbidden');
        echo "Invalid user name or password";
        exit(0);
      }

      $ldap = new ldap($this->session);

      if (!$ldap->connect()) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "LDAP connect failed";
        exit(0);
      }

      if (!$ldap->bind()) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "LDAP connect failed";
        exit(0);
      }

      $result = $ldap->search($user_name);
      if (!$result) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "LDAP connect failed";
        exit(0);
      }

      if (($dn = $ldap->get_dn($result)) == FALSE) {
        header('HTTP/1.1 403 Forbidden');
        echo "Invalid user name";
        exit(0);
      }

      if (!$ldap->login($dn, $passwd)) {
        header('HTTP/1.1 403 Forbidden');
        echo "Bad password";
        exit(0);
      }

      $this->session->set("logged_in", "none", TRUE);
      $this->session->set("user_name", "none", $user_name);

      $ldap->close();

      return TRUE;

    }

    public function print_login_page() {

      if ($this->session->get("use_ldap", "ldap") != "FALSE") {

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Login Form
    </title>
    <!--[if lt IE 7]>
      <link rel="stylesheet" href="/common/css/ie6fix.css" type="text/css">
    <![endif]-->
    <link rel="stylesheet" href="/common/css/common.css" type="text/css" />
    <link rel="stylesheet" href="/access/css/access.css" type="text/css" />
    <script src="/common/jscript/ajax.js" type="text/javascript"></script>
    <script src="/access/jscript/access.js" type="text/javascript"></script>
  </head>
  <body onload="javascript:document.getElementById('user_name').focus();" class="common blue_steel">
    <div id="access_freeze_panel">
      <div class="access freeze panel"></div>
      <div class="access inner panel">
        <div class="common blue_steel title">
          <span class=common blue_steel title">ASC user login</span>
        </div>
        <div class="common blue_steel content with_title left top">
          <form mehod="POST" onsubmit="javascript:access_login('standard');return false;">
            <div class="access user_name label">User name:</div><div class="access user_name field"><input style="width:150px;" name="user_name" type="text" id="user_name"></div>
            <div class="access password label">Password:</div><div class="access password field"><input style="width:150px;" name="password" type="password" id="password"></div>
            <div class="access login button"><input type="submit" value="login" /></div>
          </form>
          <div class="access messages" id="access_messages"></div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php

        exit(0);
      } else {
        $this->session->set("logged_in", "none", TRUE);
        $this->session->set("user_name", "none", "none");
      }
    }

  }

?>
