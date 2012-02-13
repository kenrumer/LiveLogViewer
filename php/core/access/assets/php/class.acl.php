<?php

  class ACL {
    var $perms = array();		//Array : Stores the permissions for the user
    var $userID = 0;			//Integer : Stores the ID of the current user
    var $userRoles = array();	//Array : Stores the roles of the current user

    function __constructor($userID = '') {
      if ($userID != '') {
        $this->userID = floatval($userID);
      } else {
        $this->userID = floatval($_SESSION['userID']);
      }
      $this->userRoles = $this->getUserRoles('ids');
      $this->buildACL();
    }

    function ACL($userID = '') {
      $this->__constructor($userID);
    }
		
    function buildACL() {
      //first, get the rules for the user's role
      if (count($this->userRoles) > 0) {
        $this->perms = array_merge($this->perms, $this->getRolePerms($this->userRoles));
      }
      //then, get the individual user permissions
      $this->perms = array_merge($this->perms, $this->getUserPerms($this->userID));
    }

		function getPermKeyFromID($permID) {
			$strSQL = "SELECT p.key FROM access.permission p WHERE p.idpermission=".floatval($permID)." LIMIT 1";
			$result = pg_query($strSQL);
			$row = pg_fetch_array($result);
			return $row[0];
		}
		
		function getPermNameFromID($permID)
		{
			$strSQL = "SELECT p.name FROM access.permission p WHERE p.idpermission=".floatval($permID)." LIMIT 1";
			$result = pg_query($strSQL);
			$row = pg_fetch_array($result);
			return $row[0];
		}
		
		function getRoleNameFromID($roleID)
		{
			$strSQL = "SELECT r.name FROM access.role r WHERE r.idrole=".floatval($roleID)." LIMIT 1";
			$result = pg_query($strSQL);
			$row = pg_fetch_array($result);
			return $row[0];
		}
		
		function getUserRoles()
		{
			$strSQL = "SELECT ur.* FROM access.user_role ur WHERE ur.user_iduser=".floatval($this->userID)." ORDER BY ur.add_date ASC";
			$result = pg_query($strSQL);
			$ret_array = array();
			while($row = pg_fetch_array($result))
			{
				$ret_array[] = $row['role_idrole'];
			}
			return $ret_array;
		}
		
		function getAllRoles($format='ids')
		{
			$format = strtolower($format);
			$strSQL = "SELECT r.* FROM access.role r ORDER BY r.name ASC";
			$result = pg_query($strSQL);
			$ret_array = array();
			while($row = pg_fetch_array($result))
			{
				if ($format == 'full')
				{
					$ret_array[] = array("ID" => $row['idrole'],"Name" => $row['name']);
				} else {
					$ret_array[] = $row['idrole'];
				}
			}
			return $ret_array;
		}
		
		function getAllPerms($format='ids')
		{
			$format = strtolower($format);
			$strSQL = "SELECT p.* FROM access.permission p ORDER BY p.name ASC";
			$result = pg_query($strSQL);
			$ret_array = array();
			while($row = pg_fetch_assoc($result))
			{
				if ($format == 'full')
				{
					$ret_array[$row['key']] = array('ID' => $row['idpermission'], 'Name' => $row['name'], 'Key' => $row['key']);
				} else {
					$ret_array[] = $row['idpermission'];
				}
			}
			return $ret_array;
		}

		function getRolePerms($role)
		{
			if (is_array($role))
			{
				$roleSQL = "SELECT rp.* FROM access.role_permission rp WHERE rp.role_idrole IN (".implode(",",$role).") ORDER BY rp.idrole_permission ASC";
			} else {
				$roleSQL = "SELECT rp.* FROM access.role_permission rp WHERE rp.role_idrole=".floatval($role)." ORDER BY rp.idrole_permission ASC";
			}
			$result = pg_query($roleSQL);
			$ret_array = array();
			while($row = pg_fetch_assoc($result))
			{
				$pK = strtolower($this->getPermKeyFromID($row['permission_idpermission']));
				if ($pK == '') { continue; }
				if ($row['value'] === '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$ret_array[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'Name' => $this->getPermNameFromID($row['permission_idpermission']),'ID' => $row['permission_idpermission']);
			}
			return $ret_array;
		}
		
		function getUserPerms($userID)
		{
			$strSQL = "SELECT up.* FROM access.user_permission up WHERE up.user_iduser=".floatval($userID)." ORDER BY up.add_date ASC";
			$result = pg_query($strSQL);
			$ret_array = array();
			while($row = pg_fetch_assoc($result))
			{
				$pK = strtolower($this->getPermKeyFromID($row['permission_idpermission']));
				if ($pK == '') { continue; }
				if ($row['value'] == '1') {
					$hP = true;
				} else {
					$hP = false;
				}
				$ret_array[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'Name' => $this->getPermNameFromID($row['permission_idpermission']),'ID' => $row['permission_idpermission']);
			}
			return $ret_array;
		}
		
		function userHasRole($roleID)
		{
			foreach($this->userRoles as $k => $v)
			{
				if (floatval($v) === floatval($roleID))
				{
					return true;
				}
			}
			return false;
		}
		
		function hasPermission($permKey)
		{
			$permKey = strtolower($permKey);
			if (array_key_exists($permKey,$this->perms))
			{
				if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
				{
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		
		function getUsername($userID)
		{
			$strSQL = "SELECT u.user_name FROM access.user u WHERE u.iduser=".floatval($userID)." LIMIT 1";
			$result = pg_query($strSQL);
			$row = pg_fetch_array($result);
			return $row[0];
		}
	}

?>
