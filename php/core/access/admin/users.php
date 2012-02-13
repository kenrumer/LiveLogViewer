<?php

  include("../../common/include/database.inc"); 
  include("../assets/php/class.acl.php");

  $myACL = new ACL();
  if (isset($_POST['action']))
  {
    switch($_POST['action'])
    {
      case 'saveRoles':
        $redir = "?action=user&userID=" . $_POST['userID'];
        foreach ($_POST as $k => $v) {
          if (substr($k,0,5) == "role_") {
            $roleID = str_replace("role_","",$k);
            if ($v == '0' || $v == 'x') {
              $strSQL = sprintf("DELETE FROM acl.user_roles WHERE ur.userID=%u AND ur.roleID=%u",$_POST['userID'],$roleID);
            } else {
              $strSQL = sprintf("REPLACE INTO acl.user_roles SET ur.userID=%u, ur.roleID=%u, addDate='%s'",$_POST['userID'],$roleID,date ("Y-m-d H:i:s"));
            }
            pg_query($strSQL);
          }
        }
        break;
      case 'savePerms':
        $redir = "?action=user&userID=" . $_POST['userID'];
        foreach ($_POST as $k => $v) {
          if (substr($k,0,5) == "perm_") {
            $permID = str_replace("perm_","",$k);
            if ($v == 'x') {
              $strSQL = sprintf("DELETE FROM acl.user_perms WHERE userID=%u AND permID=%u",$_POST['userID'],$permID);
            } else {
              $strSQL = sprintf("REPLACE INTO acl.user_perms SET userID=%u, permID=%u, value=%u, addDate='%s'",$_POST['userID'],$permID,$v,date ("Y-m-d H:i:s"));
            }
            pg_query($strSQL);
          }
        }
        break;
    }
    header("location: users.php".$redir);
  }
  if ($myACL->hasPermission('access_admin') != true) {
    header("location: ../index.php");
  }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      ACL Test
    </title>
    <link href="../assets/css/styles.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div id="header"></div>
    <div id="adminButton"><a href="../index.php">Main Screen</a> | <a href="index.php">Admin Home</a></div>
    <div id="page">
<?php

  if ($_GET['action'] == '' ) {

?>
      <h2>
        Select a User to Manage:
      </h2>
<?php

    $strSQL = "SELECT * FROM access.user u ORDER BY u.user_name ASC";
    $result = pg_query($strSQL);
		while ($row = pg_fetch_assoc($result)) {
      echo "    	    <a href=\"?action=user&userID=".$row['ID']."\">".$row['username']."</a><br />";
    }
  }
  if ($_GET['action'] == 'user' ) { 
    $userACL = new ACL($_GET['userID']);
?>
    	<h2>
        Managing <?php echo ($myACL->getUsername($_GET['userID'])); ?>:
      </h2>
      ... Some form to edit user info ...
      <h3>
        Roles for user:   (<a href="users.php?action=roles&userID=<?php echo ($_GET['userID']); ?>">Manage Roles</a>)
      </h3>
      <ul>
<?php

    $roles = $userACL->getUserRoles();
    foreach ($roles as $k => $v) {
      echo "        <li>$userACL->getRoleNameFromID($v)</li>";
    }

?>
      </ul>
      <h3>
        Permissions for user:   (<a href="users.php?action=perms&userID=<?php echo ($_GET['userID']); ?>">Manage Permissions</a>)
      </h3>
      <ul>
<?php

    $perms = $userACL->perms;
    foreach ($perms as $k => $v) {
      if ($v['value'] === false) {
        continue;
      }
      echo "        <li>";
      if ($v['inheritted']) {
        echo $v['Name']." (inheritted)</li>";
      } else {
        echo $v['Name']."</li>";
      }
    }

?>
      </ul>
<?php

  }
  if ($_GET['action'] == 'roles') {

?>
     <h2>Manage User Roles: (<?php echo ($myACL->getUsername($_GET['userID'])); ?>)</h2>
       <form action="users.php" method="post">
        <table border="0" cellpadding="5" cellspacing="0">
          <tr>
            <th>
            </th>
            <th>
              Member
            </th>
            <th>
              Not Member
            </th>
          </tr>
<?php

		$roleACL = new ACL($_GET['userID']);
		$roles = $roleACL->getAllRoles('full');
    foreach ($roles as $k => $v) {
      echo "<tr><td><label>".$v['Name']."</label></td>";
      echo "<td><input type=\"radio\" name=\"role_".$v['ID']."\" id=\"role_".$v['ID']."_1\" value=\"1\"";
      if ($roleACL->userHasRole($v['ID'])) { echo " checked=\"checked\""; }
      echo " /></td>";
      echo "<td><input type=\"radio\" name=\"role_".$v['ID']."\" id=\"role_".$v['ID']."_0\" value=\"0\"";
      if (!$roleACL->userHasRole($v['ID'])) { echo " checked=\"checked\""; }
      echo " /></td>";
      echo "</tr>";
    }

?>
        </table>
        <input type="hidden" name="action" value="saveRoles" />
        <input type="hidden" name="userID" value="<?php echo ($_GET['userID']); ?>" />
        <input type="submit" name="Submit" value="Submit" />
      </form>
      <form action="users.php" method="post">
    	  <input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?php echo ($_GET['userID']); ?>'" value="Cancel" />
      </form>
<?php

  }
  if ($_GET['action'] == 'perms' ) {

?>
    	<h2>Manage User Permissions: (<?php echo ($myACL->getUsername($_GET['userID'])); ?>)</h2>
      <form action="users.php" method="post">
        <table border="0" cellpadding="5" cellspacing="0">
          <tr>
            <th>
            </th>
            <th>
            </th>
          </tr>
<?php

    $userACL = new ACL($_GET['userID']);
    $rPerms = $userACL->perms;
    $aPerms = $userACL->getAllPerms('full');
    foreach ($aPerms as $k => $v) {
      echo "<tr><td>" . $v['Name'] . "</td>";
			echo "<td><select name=\"perm_" . $v['ID'] . "\">";
			echo "<option value=\"1\"";
			if ($userACL->hasPermission($v['Key']) && $rPerms[$v['Key']]['inheritted'] != true) { echo " selected=\"selected\""; }
			echo ">Allow</option>";
			echo "<option value=\"0\"";
			if ($rPerms[$v['Key']]['value'] === false && $rPerms[$v['Key']]['inheritted'] != true) { echo " selected=\"selected\""; }
			echo ">Deny</option>";
			echo "<option value=\"x\"";
			if ($rPerms[$v['Key']]['inheritted'] == true || !array_key_exists($v['Key'],$rPerms)) {
				echo " selected=\"selected\"";
				if ($rPerms[$v['Key']]['value'] === true ) {
					$iVal = '(Allow)';
				} else {
					$iVal = '(Deny)';
				}
			}
			echo ">Inherit $iVal</option>";
      echo "</select></td></tr>";
    }

?>
    	  </table>
    	  <input type="hidden" name="action" value="savePerms" />
        <input type="hidden" name="userID" value="<?= $_GET['userID']; ?>" />
    	  <input type="submit" name="Submit" value="Submit" />
      </form>
      <form action="users.php" method="post">
    	  <input type="button" name="Cancel" onclick="window.location='?action=user&userID=<?= $_GET['userID']; ?>'" value="Cancel" />
      </form>
<?php

  }

?>
    </div>
  </body>
</html>
