<?php

  include("../common/include/header.inc"); 
  include("assets/php/class.acl.php");

  $userID = $_GET['userID'];
  $_SESSION['userID'] = 1;
  $myACL = new ACL();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ACL Test</title>
    <link href="assets/css/styles.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="header"></div>
    <div id="adminButton"><a href="admin/index.php">Admin Screen</a></div>
    <div id="page">
	    <h2>Permissions for <?php echo ($myACL->getUsername($userID)); ?>:</h2>
<?php 

  $userACL = new ACL($userID);
  $aPerms = $userACL->getAllPerms('full');
  foreach ($aPerms as $k => $v) {
    echo "<strong>" . $v['Name'] . ": </strong>";
    echo "<img src=\"/common/images/";
    if ($userACL->hasPermission($v['Key']) === true) {
      echo "allow.png";
      $pVal = "Allow";
    } else {
      echo "deny.png";
      $pVal = "Deny";
    }
    echo "\" width=\"16\" height=\"16\" alt=\"$pVal\" /><br />";
  }

?>
	    <h3>Change User:</h3>
<?php
 
  $strSQL = "SELECT * FROM access.user u ORDER BY u.user_name ASC";
  $data = pg_query($strSQL);
  while ($row = pg_fetch_assoc($data)) {
    echo "<a href=\"?userID=".$row['iduser']."\">".$row['user_name']."</a><br />";
  }

?>
    </div>
  </body>
</html>
