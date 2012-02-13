<?php

  class database {

    private $connection;
    private $connection_string;

    public function database($session) {

      $this->connection_string = "host=".$session->get("hostname", "database")." port=".$session->get("port", "database")." dbname=".$session->get("schema", "database")." user=".$session->get("user_name", "database")." password=".$session->get("passwd", "database");
      $this->connection = pg_connect($this->connection_string) or die ('Error connecting to database');

    }

    public function get_connection() {

      if (pg_connection_status($this->connection) == PGSQL_CONNECTION_OK) {
        return $this->connection;
      } else {
        return pg_connect($this->connection_string);
      }

    }

    public function database_close() {

      @pg_close($this->connection);

    }

    public function write_logon($user_name) {

      $query = "UPDATE users.user SET logon_count=logon_count + 1, last_logon=now(), bad_password_count=0 WHERE user_name='".$user_name."'";
      pg_query($query);
      return $session_id;

    }

    public function is_valid_user($user_name) {

      $query = "SELECT u.user_name FROM users.user u WHERE u.user_name='".$user_name."'";
      $result = pg_query($this->connection, $query);
      if (pg_num_rows($result) == 1) {
        return TRUE;
      }
      return FALSE;

    }

    public function write_bad_logon($user_name) {

      $query = "UPDATE users.user SET bad_password_time=now(), bad_password_count=bad_password_count + 1 WHERE user_name='".$user_name."'";
      pg_query($query);
      return true;

    }

    public function get_group_for_user($user_name) {

      $ret_array = array();
      $query = "SELECT ug.iduser_group as id, ug.* FROM inventory.user u, inventory.user_group_user ugu, inventory.user_group ug WHERE u.user_name='".$user_name."' AND u.iduser=ugu.user_iduser AND ug.iduser_group=ugu.user_group_iduser_group";
      $ret_array = pg_fetch_all(pg_query($query));
      return $ret_array[0];

    }

    public function get_groups_for_user($user_name) {

      $query = "SELECT g.idgroup as id, g.* FROM users.user u, pager_rotation.group g, pager_rotation.group_admin ga WHERE u.user_name='".$user_name."' AND u.iduser=ga.user_iduser AND g.idgroup=ga.group_idgroup";
      return pg_fetch_all(pg_query($query));

    }

    public function get_asc_user_groups() {

      $query = "SELECT g.iduser_group as id, g.* FROM inventory.user_group g";
      return pg_fetch_all(pg_query($query));

    }

    public function remove_user($user_name) {

      $query = "DELETE FROM inventory.user u WHERE u.user_name='$user_name'";
      $result = pg_query($query);
      return TRUE;

    }

    public function new_user($user_name) {

      $query = "INSERT INTO inventory.user (user_name) VALUES ('$user_name')";
      $result = @pg_query($query);
      $query = "INSERT INTO users.user (user_name) VALUES ('$user_name')";
      $result = @pg_query($query);
      return TRUE;

    }

    public function save_user($user_name, $display_name, $first_name, $last_name, $office, $department, $title, $manager, $email_address, $sms_number, $phone_number, $cell_phone_number, $group_id) {

      $query = "UPDATE users.user SET display_name='$display_name', first_name='$first_name', last_name='$last_name', office='$office', department='$department', title='$title', manager='$manager', email_address='$email_address', sms_number='$sms_number', phone_number='$phone_number', cell_phone_number='$cell_phone_number' WHERE user_name='$user_name'";
      $result = @pg_query($query);
      $user = $this->get_asc_user($user_name);
      $query = "SELECT * FROM inventory.user_group_user WHERE user_iduser=".$user['id'];
      $result = pg_query($query);
      if (pg_num_rows($result) == 0) {
        $query = "INSERT INTO inventory.user_group_user (user_iduser, user_group_iduser_group) VALUES (".$user['id'].", $group_id)";
        $result = pg_query($query);
      } else {
        $query = "UPDATE inventory.user_group_user SET user_group_iduser_group=$group_id WHERE user_iduser=".$user['id'];
        $result = pg_query($query);
      }
      return TRUE;

    }

    public function get_user_attributes($user_name) {

      $ret_array = array();
      $query = "SELECT u.iduser as id, u.* FROM users.user u WHERE u.user_name='$user_name'";
      $result = pg_query($query);
      $ret_array = pg_fetch_all($result);
      return $ret_array[0];

    }

    public function get_pager_users() {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name, u.pager_email FROM users.user u WHERE u.pager_email IS NOT NULL";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function get_current_user_for_group($group_id) {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name, u.pager_email FROM pager_rotation.group g, users.user u WHERE g.idgroup=".$group_id." AND g.current_oncall=u.iduser";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function set_current_user_for_group($group_id, $user_id) {

      $query = "UPDATE pager_rotation.group g SET current_oncall=".$user_id." WHERE g.idgroup=".$group_id;
      $result = pg_query($query);
      return true;

    }

    public function get_pager_users_for_group($group_id) {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name, u.pager_email, u.primary_phone_number, gp.position FROM pager_rotation.group g, pager_rotation.group_pager gp, users.user u WHERE g.idgroup=".$group_id." AND gp.group_idgroup=g.idgroup AND gp.user_iduser=u.iduser ORDER BY gp.position";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function clear_pager_users_for_group($group_id) {

      $query = "DELETE FROM pager_rotation.group_pager gp WHERE gp.group_idgroup=".$group_id;
      $result = pg_query($query);
      return true;

    }

    public function add_pager_user_to_group($group_id, $user_id, $position) {

      $query = "INSERT INTO pager_rotation.group_pager (group_idgroup, user_iduser, position) VALUES (".$group_id.", ".$user_id.", ".$position.")";
      $result = pg_query($query);
      return true;

    }

    public function get_email_users() {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name, u.primary_email FROM users.user u WHERE u.primary_email IS NOT NULL";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function get_email_users_for_group($group_id) {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name, u.primary_email FROM pager_rotation.group g, pager_rotation.group_user gu, users.user u WHERE g.idgroup=".$group_id." AND gu.group_idgroup=g.idgroup AND gu.user_iduser=u.iduser";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function clear_email_users_for_group($group_id) {

      $query = "DELETE FROM pager_rotation.group_user gu WHERE gu.group_idgroup=".$group_id;
      $result = pg_query($query);
      return true;

    }

    public function add_email_user_to_group($group_id, $user_id) {

      $query = "INSERT INTO pager_rotation.group_user (group_idgroup, user_iduser) VALUES (".$group_id.", ".$user_id.")";
      $result = pg_query($query);
      return true;

    }

    public function get_asc_users() {

      $query = "SELECT u.* FROM users.user u, inventory.user iu WHERE u.user_name=iu.user_name ORDER BY u.first_name";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function get_asc_user($user_name) {

      $query = "SELECT u.*, u.iduser as id FROM inventory.user u WHERE u.user_name='$user_name'";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_users() {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name FROM users.user u";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function get_users_for_group($group_id) {

      $query = "SELECT u.iduser as id, u.user_name, u.first_name, u.last_name FROM pager_rotation.group g, pager_rotation.group_admin ga, users.user u WHERE g.idgroup=".$group_id." AND ga.group_idgroup=g.idgroup AND ga.user_iduser=u.iduser";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function clear_users_for_group($group_id) {

      $query = "DELETE FROM pager_rotation.group_admin ga WHERE ga.group_idgroup=".$group_id;
      $result = pg_query($query);
      return true;

    }

    public function add_user_to_group($group_id, $user_id) {

      $query = "INSERT INTO pager_rotation.group_admin (group_idgroup, user_iduser) VALUES (".$group_id.", ".$user_id.")";
      $result = pg_query($query);
      return true;

    }

    public function get_current_position_for_group($group_id) {

      $query = "SELECT g.position FROM pager_rotation.group g WHERE g.idgroup=".$group_id;
      $result = pg_query($query);
      $ret_array = pg_fetch_all($result);
      return $ret_array[0]['position'];

    }

    public function get_schedule_for_group($group_id) {

      $query = "SELECT gs.idgroup_schedule as id, gs.group_idgroup, gs.time, gs.date, gs.type FROM pager_rotation.group_schedule gs WHERE gs.group_idgroup=".$group_id;
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function get_group($group_id) {

      $ret_array = array();
      $query = "SELECT g.idgroup as id, g.* FROM pager_rotation.group g WHERE g.idgroup=".$group_id;
      $result = pg_query($query);
      $ret_array = pg_fetch_all($result);
      return $ret_array[0];

    }

    public function get_schedules() {

      $query = "SELECT gs.group_idgroup as group_id, gs.idgroup_schedule as id, gs.time, gs.date, gs.type FROM pager_rotation.group_schedule gs";
      $result = pg_query($query);
      return pg_fetch_all($result);

    }

    public function clear_schedule_for_group($group_id) {

      $query = "DELETE FROM pager_rotation.group_schedule gs WHERE gs.group_idgroup=".$group_id;
      $result = pg_query($query);
      return true;

    }

    public function add_schedule_to_group($group_id, $type, $time, $date) {

      $query = "INSERT INTO pager_rotation.group_schedule (group_idgroup, type, time, date) VALUES (".$group_id.", '".$type."', '".$time."', '".$date."')";
      $result = pg_query($query);
      return true;

    }

    public function get_group_ids($user_name) {

      $query = "SELECT ug.iduser_group FROM inventory.user u, inventory.user_group ug, inventory.user_group_user ugu WHERE u.iduser=ugu.user_iduser AND ugu.user_group_iduser_group=ug.iduser_group AND u.user_name='".$user_name."'";
      return pg_fetch_all(pg_query($query));

    }

    public function get_guid_by_name($ci_name) {

      $ret_array = array();

      $query = "SELECT t.ci_table FROM asc.type t";
      $rows = pg_fetch_all(pg_query($query));

      foreach($rows as $row) {
        $query = "SELECT c.id FROM asc.".$row['ci_table']." c WHERE c.name='".$ci_name."'";
        $value = pg_fetch_array(pg_query($query));
        if (count($value[0])) {
          return $value[0];
        }
      }
      return NULL;

    }

    public function get_item($type, $id) {

      $ret_array = array();
      $query = "SELECT i.*, i.id".$type." as id FROM inventory.".$type." i WHERE i.id".$type."=".$id;
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_item_tables($type, $id) {

      $ret_array = array();
      $query = "SELECT table_name as name FROM information_schema.tables WHERE table_schema='$type'";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $query = "SELECT COUNT(*) as rows FROM $type.\"".$row['name']."\" WHERE ".$type."_id$type=$id";
        $result2 = pg_query($query);
        $count = pg_fetch_array($result2);
        if ($count['rows'] > 0) {
          $ret_array[] = $row['name'];
        }
      }
      return $ret_array;

    }

    public function get_item_table_for_item($type, $table, $id) {

      $ret_array = array();
      $query = "SELECT i.id$table as id, name FROM $type.\"$table\" i WHERE ".$type."_id$type=$id";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function add_server_to_core($name, $host_name, $fqdn, $ip_address, $os) {

      $query = "INSERT INTO inventory.server (name, hostname, fqdn, primary_ip, os) VALUES ('$name', '$host_name', '$fqdn', '$ip_address', 'Solaris 10')";
      @pg_query($query);
      $query = "SELECT * FROM inventory.server s WHERE s.name='$name'";
      $row = pg_fetch_array(pg_query($query));
      $server_id = $row['idserver'];
      switch ($os) {
        case "SunOS":
          $query = "SELECT sg.idserver_group FROM inventory.server_group sg WHERE name='UNIX Servers'";
          $row = pg_fetch_array(pg_query($query));
          $server_group_id = $row['idserver_group'];
          $query = "INSERT INTO inventory.server_group_server (server_idserver, server_group_idserver_group) VALUES ($server_id, $server_group_id)";
          @pg_query($query);
          break;
        case "WINNT":
          $query = "SELECT sg.idserver_group FROM inventory.server_group sg WHERE name='Windows Servers'";
          $row = pg_fetch_array(pg_query($query));
          $server_group_id = $row['idserver_group'];
          $query = "INSERT INTO inventory.server_group_server (server_idserver, server_group_idserver_group) VALUES ($server_id, $server_group_id)";
          @pg_query($query);
          break;
        default:
          $query = "SELECT sg.idserver_group FROM inventory.server_group sg WHERE name='Other OS Servers'";
          $row = pg_fetch_array(pg_query($query));
          $server_group_id = $row['idserver_group'];
          $query = "INSERT INTO inventory.server_group_server (server_idserver, server_group_idserver_group) VALUES ($server_id, $server_group_id)";
          @pg_query($query);
          break;
      }
      return TRUE;

    }

    public function get_server($server_id) {

      $ret_array = array();
      $query = "SELECT s.*, s.idserver as id FROM inventory.server s WHERE s.idserver=$server_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_server_by_name($server_name) {

      $ret_array = array();
      $query = "SELECT s.* FROM inventory.server s WHERE s.name='$server_name' OR s.fqdn='$server_name'";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_server_table($table, $server_id) {

      $ret_array = array();
      $query = "SELECT i.*, i.id$table as id FROM inventory.$table i, inventory.server s WHERE s.idserver=$server_id AND i.server_idserver=s.idserver";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_paths() {

      $ret_array = array();
      $query = "SELECT p.*, p.idpath as id FROM inventory.path p ORDER BY name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function remove_path_from_server($server_id, $path_id) {

      $query = "DELETE FROM inventory.path_server ps WHERE ps.server_idserver=$server_id AND ps.path_idpath=$path_id";
      @pg_query($query);
      return TRUE;

    }

    public function add_path_to_server($server_id, $path_id) {

      $query = "INSERT INTO inventory.path_server (server_idserver, path_idpath) VALUES ($server_id, $path_id)";
      @pg_query($query);
      return TRUE;

    }

    public function get_paths_in_server($server_id) {

      $ret_array = array();
      $query = "SELECT p.*, p.idpath as id FROM inventory.path p, inventory.path_server ps WHERE ps.server_idserver=$server_id AND p.idpath=ps.path_idpath AND ps.allowed=TRUE";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_server_facility($server_id) {

      $ret_array = array();
      $query = "SELECT f.* FROM inventory.facility f, inventory.server s WHERE s.idserver=$server_id AND f.name=s.facility";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function new_server_group($name, $description, $parent_server_group_id) {

      $query = "INSERT INTO inventory.server_group (name, description) VALUES ('$name', '$description')";
      @pg_query($query);
      $query = "SELECT sg.*, sg.idserver_group as id FROM inventory.server_group sg WHERE sg.name='$name' AND sg.description='$description'";
      $result = pg_query($query);
      $row = pg_fetch_array($result);
      $server_group_id = $row['id'];
      $query = "INSERT INTO inventory.server_group_server_group (server_group_idserver_group_parent, server_group_idserver_group_child) VALUES ($parent_server_group_id, $server_group_id)";
      return TRUE;

    }

    public function new_server($name, $hostname, $fqdn, $primary_ip, $os, $facility, $service_tag, $end_of_service_life) {

      if ($end_of_service_life == "") {
        $query = "INSERT INTO inventory.server (name, hostname, fqdn, primary_ip, os, facility, service_tag, end_of_service_life) VALUES ('$name', '$hostname', '$fqdn', '$primary_ip', '$os', '$facility', '$service_tag', NULL)";
      } else {
        $query = "INSERT INTO inventory.server (name, hostname, fqdn, primary_ip, os, facility, service_tag, end_of_service_life) VALUES ('$name', '$hostname', '$fqdn', '$primary_ip', '$os', '$facility', '$service_tag', '$end_of_service_life')";
      }
      $result = @pg_query($query);

    }

    public function new_path($name, $is_root, $is_directory) {

      $query = "INSERT INTO inventory.path (name, is_root, is_directory) VALUES ('$name', $is_root, $is_directory)";
      $result = @pg_query($query);

    }

    public function update_server_group($server_group_id, $name, $description, $parent_server_group_id) {

      $query = "UPDATE inventory.server_group SET name='$name', description='$description' WHERE idserver_group=$server_group_id";
      @pg_query($query);
      $query = "DELETE FROM inventory.server_group WHERE server_group_idserver_group_child=$server_group_id";
      @pg_query($query);
      $query = "INSERT INTO inventory.server_group_server_group (server_group_idserver_group_parent, server_group_idserver_group_child) VALUES ($parent_server_group_id, $server_group_id)";
      @pg_query($query);
      return TRUE;

    }

    public function update_server($server_id, $name, $hostname, $os, $facility, $service_tag, $end_of_service_life) {

      if ($end_of_service_life == "") {
        $query = "UPDATE inventory.server SET name='$name', hostname='$hostname', os='$os', facility='$facility', service_tag='$service_tag', end_of_service_life=NULL WHERE idserver=$server_id";
      } else {
        $query = "UPDATE inventory.server SET name='$name', hostname='$hostname', os='$os', facility='$facility', service_tag='$service_tag', end_of_service_life='$end_of_service_life' WHERE idserver=$server_id";
      }
      $result = pg_query($query);

    }

    public function update_path($path_id, $name, $is_root, $is_directory) {

      $query = "UPDATE inventory.path SET name='$name', is_root=$is_root, is_directory=$is_directory WHERE idpath=$path_id";
      $result = pg_query($query);

    }

    public function get_my_item_group_id($type, $user_name) {

      $query = "SELECT igu.".$type."_group_id".$type."_group as id FROM inventory.user u, inventory.".$type."_group_user igu WHERE u.user_name='".$user_name."' AND u.iduser=igu.user_iduser";
      $result = pg_query($query);
      if (pg_num_rows($result) == 0) {
        $query = "SELECT u.iduser AS id FROM inventory.user u WHERE u.user_name='".$user_name."'";
        $row = pg_fetch_array(pg_query($query));
        $user_id = $row['id'];
        $query = "INSERT INTO inventory.".$type."_group (name) VALUES ('".$user_name."_group')";
        $result = pg_query($query);
        $query = "SELECT ig.id".$type."_group AS id FROM inventory.".$type."_group ig WHERE ig.name='".$user_name."_group'";
        $row = pg_fetch_array(pg_query($query));
        $group_id = $row['id'];
        $query  = "INSERT INTO inventory.".$type."_group_user (user_iduser, ".$type."_group_id".$type."_group) VALUES (".$user_id.", ".$group_id.")";
        $result = pg_query($query);
        $query = "SELECT igu.".$type."_group_id".$type."_group as id FROM inventory.user u, inventory.".$type."_group_user igu WHERE u.user_name='".$user_name."' AND u.iduser=igu.user_iduser";
        $result = pg_query($query);
      }
      $row = pg_fetch_array($result);
      return $row["id"];

    }

    public function add_item_to_item_group_by_id($type, $parent_id, $id) {

      $query = "INSERT INTO inventory.".$type."_group_".$type." (".$type."_group_id".$type."_group, ".$type."_id".$type.") VALUES (".$parent_id.", ".$id.")";
      @pg_query($query);
      return TRUE;

    }

    public function add_denied_path_to_server_by_id($server_id, $add_id) {

      $query = "INSERT INTO inventory.path_server (path_idpath, server_idserver, allowed) VALUES ($add_id, $server_id, FALSE)";
      pg_query($query);
      return TRUE;

    }

    public function add_allowed_path_to_server_by_id($server_id, $add_id) {

      $query = "INSERT INTO inventory.path_server (path_idpath, server_idserver, allowed) VALUES ($add_id, $server_id, TRUE)";
      pg_query($query);
      return TRUE;

    }

    public function remove_all_paths_from_server($server_id) {

      $query = "DELETE FROM inventory.path_server WHERE server_idserver=$server_id";
      pg_query($query);
      return TRUE;

    }

    public function remove_all_items_from_item_group($type, $id) {

      $query = "DELETE FROM inventory.".$type."_group_".$type." igi WHERE igi.".$type."_group_id".$type."_group=".$id;
      pg_query($query);
      return TRUE;

    }

    public function add_item_group_to_item_group_by_id($type, $parent_id, $id) {

      $query = "INSERT INTO inventory.".$type."_group_".$type."_group (".$type."_group_id".$type."_group_parent, ".$type."_group_id".$type."_group_child) VALUES (".$parent_id.", ".$id.")";
      $result = pg_query($query);
      return TRUE;

    }

    public function add_item_group_to_item_group($type, $id, $name) {

      $query = "INSERT INTO inventory.".$type."_group (name) VALUES ('".$name."')";
      $result = pg_query($query);
      $ret_array = array();
      $query = "SELECT * FROM inventory.".$type."_group g WHERE g.name='".$name."' ORDER BY g.id".$type."_group DESC";
      $result = pg_query($query);
      $row = pg_fetch_array($result);
      $ret_id = $row["id".$type."_group"];
      $query = "INSERT INTO inventory.".$type."_group_".$type."_group (".$type."_group_id".$type."_group_parent, ".$type."_group_id".$type."_group_child) VALUES (".$id.", ".$ret_id.")";
      $result = pg_query($query);
      return $ret_id;

    }

    public function remove_path($id) {

      $query = "DELETE FROM inventory.path_server WHERE path_idpath=$id";
      pg_query($query);
      $query = "DELETE FROM inventory.path WHERE idpath=$id";
      pg_query($query);

    }

    public function remove_item($type, $id) {

      //$query = "DELETE FROM inventory.application_group_".$type." WHERE ".$type."_id".$type."=$id";
      //$query = "DELETE FROM inventory.database_group_".$type." WHERE ".$type."_id".$type."=$id";
      //$query = "DELETE FROM inventory.network_group_".$type." WHERE ".$type."_id".$type."=$id";
      $query = "DELETE FROM inventory.server_group_".$type." WHERE ".$type."_id".$type."=$id";
      @pg_query($query);
      $query = "DELETE FROM inventory.".$type." WHERE id".$type."=".$id;
      @pg_query($query);

    }

    public function remove_item_group_from_item_group($type, $id) {

      $query = "SELECT igig.".$type."_group_id".$type."_group_child as id FROM inventory.".$type."_group_".$type."_group igig WHERE igig.".$type."_group_id".$type."_group_parent=".$id;
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $this->remove_item_group_from_item_group($type, $row["id"]);
      }
      $query = "DELETE FROM inventory.".$type."_group_".$type."_group igig WHERE igig.".$type."_group_id".$type."_group_child=".$id;
      $result = pg_query($query);
      $query = "DELETE FROM inventory.".$type."_group ig WHERE ig.id".$type."_group=".$id;
      $result = pg_query($query);
      return TRUE;

    }

    public function remove_item_group_from_my_item_group($type, $parent_id, $id) {

      $query = "DELETE FROM inventory.".$type."_group_".$type."_group igig WHERE igig.".$type."_group_id".$type."_group_parent=".$parent_id." AND igig.".$type."_group_id".$type."_group_child=".$id;
      $result = pg_query($query);
      return TRUE;

    }

    public function get_my_item_groups($type, $user_name) {

      $ret_array = array();
      $query = "SELECT ig.*, ig.id".$type."_group as id FROM inventory.user u, inventory.".$type."_group_user igu, inventory.".$type."_group ig WHERE u.user_name='$user_name' AND igu.user_iduser=u.iduser AND ig.id".$type."_group=igu.".$type."_group_id".$type."_group";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_item_groups_in_item_group($type, $group_id) {

      $ret_array = array();
      $query = "SELECT ig.name, ig.id".$type."_group as id FROM inventory.".$type."_group ig, inventory.".$type."_group_".$type."_group igig WHERE igig.".$type."_group_id".$type."_group_parent=".$group_id." AND ig.id".$type."_group=igig.".$type."_group_id".$type."_group_child ORDER BY ig.name";
      $result = pg_query($query);
      if ($result !== FALSE) {
        while ($row = pg_fetch_array($result)) {
          $ret_array[] = $row;
        }
      }
      return $ret_array;

    }

    public function get_item_group_name($type, $item_group_id) {

      $ret_array = array();
      $query = "SELECT ig.name FROM inventory.".$type."_group ig WHERE ig.id".$type."_group=$item_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_item_fields($type) {

      $ret_array = array();
      $query = "SELECT i.* FROM inventory.".$type." i";
      $result = pg_query($query);
      $field_count = pg_num_fields($result);
      for ($i = 0; $i < $field_count; $i++) {
        $ret_array[$i] = pg_field_name($result, $i);
      }
      return $ret_array;

    }

    public function get_server_denied_paths($id) {

      $ret_array = array();
      $query = "SELECT p.name FROM inventory.path p, inventory.path_server ps WHERE ps.server_idserver=$id AND ps.path_idpath=p.idpath AND ps.allowed=FALSE";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row['name'];
      }
      return $ret_array;

    }

    public function get_denied_paths_for_server($id) {

      $ret_array = array();
      $query = "SELECT i.*, i.idpath as id FROM inventory.path i, inventory.path_server ig WHERE ig.server_idserver=$id AND ig.path_idpath=i.idpath AND ig.allowed=FALSE";
      $result = pg_query($query);
      if ($result !== FALSE) {
        while ($row = pg_fetch_array($result)) {
          $ret_array[] = $row;
        }
      }
      return $ret_array;

    }

    public function get_allowed_paths_for_server($id) {

      $ret_array = array();
      $query = "SELECT i.*, i.idpath as id FROM inventory.path i, inventory.path_server ig WHERE ig.server_idserver=$id AND ig.path_idpath=i.idpath AND ig.allowed=TRUE";
      $result = pg_query($query);
      if ($result !== FALSE) {
        while ($row = pg_fetch_array($result)) {
          $ret_array[] = $row;
        }
      }
      return $ret_array;

    }

    public function get_items_in_item_group($type, $item_group_id) {

      $ret_array = array();
      $query = "SELECT i.*, i.id".$type." as id FROM inventory.".$type." i, inventory.".$type."_group_".$type." igi WHERE igi.".$type."_group_id".$type."_group=".$item_group_id." AND igi.".$type."_id".$type."=i.id".$type." ORDER BY i.name";
      $result = pg_query($query);
      if ($result !== FALSE) {
        while ($row = pg_fetch_array($result)) {
          $ret_array[] = $row;
        }
      }
      return $ret_array;

    }

    public function get_items($type) {

      $ret_array = array();
      $query = "SELECT i.*, i.id".$type." as id FROM inventory.".$type." i ORDER BY i.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_items_by_name($type, $name) {

      $ret_array = array();
      $query = "SELECT i.*, i.id".$type." as id FROM inventory.".$type." i WHERE i.name LIKE '%".$name."%'";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_unmanaged_items($type) {

      $ret_array = array();
      $query = "SELECT i.*, i.id".$type." as id FROM inventory.".$type." i WHERE i.id".$type." NOT IN (SELECT igi.".$type."_id".$type." FROM inventory.".$type."_group_".$type." igi) ORDER BY i.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_item_properties($type, $item_id) {

      $ret_array = array();
      $query = "SELECT i.* FROM ".$type.".ci_server WHERE s.name=\"".$server."\"";
      return pg_fetch_all(pg_query($query));

    }

    public function remove_server_group_from_server($server_id, $server_group_id) {

      $query = "DELETE FROM inventory.server_group_server sgs WHERE sgs.server_idserver=$server_id AND sgs.server_group_idserver_group=$server_group_id";
      @pg_query($query);
      return TRUE;

    }

    public function add_server_group_to_server($server_id, $server_group_id) {

      $query = "INSERT INTO inventory.server_group_server (server_idserver, server_group_idserver_group) VALUES ($server_id, $server_group_id)";
      @pg_query($query);
      return TRUE;

    }

    public function get_server_groups_for_server($server_id) {

      $ret_array = array();
      $query = "SELECT sgs.*, sgs.server_group_idserver_group as id FROM inventory.server_group_server sgs WHERE sgs.server_idserver=$server_id";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_my_server_groups($user_name) {

      $ret_array = array();
      $query = "SELECT sg.*, sg.idserver_group as id FROM inventory.user u, inventory.server_group_user sgu, inventory.server_group sg WHERE u.user_name='$user_name' AND sgu.user_iduser=u.iduser AND sg.idserver_group=sgu.server_group_idserver_group";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_server_groups() {

      $ret_array = array();
      $query = "SELECT sg.*, sg.idserver_group as id FROM inventory.server_group sg ORDER BY sg.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_server_groups_in_server_group($server_group_id) {

      $ret_array = array();
      $query = "SELECT sg.name, sg.idserver_group as id FROM inventory.server_group sg, inventory.server_group_server_group sgsg WHERE sgsg.server_group_idserver_group_parent=$server_group_id AND sg.idserver_group=sgsg.server_group_idserver_group_child ORDER BY sg.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_application_group_name($application_group_id) {

      $ret_array = array();
      $query = "SELECT ag.name FROM inventory.application_group ag WHERE ag.idapplication_group=$application_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_application_fields() {

      $ret_array = array();
      $query = "SELECT * FROM inventory.application";
      $result = pg_query($query);
      $field_count = pg_num_fields($result);
      for ($i = 0; $i < $field_count; $i++) {
        $ret_array[$i] = pg_field_name($result, $i);
      }
      return $ret_array;

    }

    public function get_database_group_name($database_group_id) {

      $ret_array = array();
      $query = "SELECT dg.name FROM inventory.database_group dg WHERE dg.iddatabase_group=$database_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_database_fields() {

      $ret_array = array();
      $query = "SELECT * FROM inventory.database";
      $result = pg_query($query);
      $field_count = pg_num_fields($result);
      for ($i = 0; $i < $field_count; $i++) {
        $ret_array[$i] = pg_field_name($result, $i);
      }
      return $ret_array;

    }

    public function get_network_group_name($network_group_id) {

      $ret_array = array();
      $query = "SELECT ng.name FROM inventory.network_group ng WHERE ng.idnetwork_group=$network_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_network_fields() {

      $ret_array = array();
      $query = "SELECT * FROM inventory.network";
      $result = pg_query($query);
      $field_count = pg_num_fields($result);
      for ($i = 0; $i < $field_count; $i++) {
        $ret_array[$i] = pg_field_name($result, $i);
      }
      return $ret_array;

    }

    public function get_server_group_parent($server_group_id) {

      $ret_array = array();
      $query = "SELECT sg.*, sg.idserver_group as id FROM inventory.server_group sg, inventory.server_group_server_group sgsg WHERE sg.idserver_group=sgsg.server_group_idserver_group_parent AND sgsg.server_group_idserver_group_child=$server_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_server_group($server_group_id) {

      $ret_array = array();
      $query = "SELECT sg.*, sg.idserver_group as id FROM inventory.server_group sg WHERE sg.idserver_group=$server_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_server_group_name($server_group_id) {

      $ret_array = array();
      $query = "SELECT sg.name FROM inventory.server_group sg WHERE sg.idserver_group=$server_group_id";
      $result = pg_query($query);
      return pg_fetch_array($result);

    }

    public function get_server_fields() {

      $ret_array = array();
      $query = "SELECT * FROM inventory.server";
      $result = pg_query($query);
      $field_count = pg_num_fields($result);
      for ($i = 0; $i < $field_count; $i++) {
        $ret_array[$i] = pg_field_name($result, $i);
      }
      return $ret_array;

    }

    public function get_applications_in_application_group($application_group_id) {

      $ret_array = array();
      $query = "SELECT a.*, a.idapplication as id FROM inventory.application a, inventory.application_group_application aga WHERE aga.application_group_idapplication_group=$application_group_id AND aga.application_idapplication=a.idapplication ORDER BY a.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_networks_in_network_group($network_group_id) {

      $ret_array = array();
      $query = "SELECT n.*, n.idnetwork as id FROM inventory.network n, inventory.network_group_network ngn WHERE ngn.network_group_idnetwork_group=$network_group_id AND ngn.network_idnetwork=n.idnetwork ORDER BY n.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_servers_in_server_group($server_group_id) {

      $ret_array = array();
      $query = "SELECT s.*, s.idserver as id FROM inventory.server s, inventory.server_group_server sgs WHERE sgs.server_group_idserver_group=$server_group_id AND sgs.server_idserver=s.idserver ORDER BY s.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_unmanaged_servers() {

      $ret_array = array();
      $query = "SELECT s.*, s.idserver as id FROM inventory.server s WHERE s.idserver NOT IN (SELECT sgs.server_idserver FROM inventory.server_group_server sgs) ORDER BY s.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_application_groups_in_application_group($application_group_id) {

      $ret_array = array();
      $query = "SELECT ag.name, ag.idapplication_group as id FROM inventory.application_group ag, inventory.application_group_application_group agag WHERE agag.application_group_idapplication_group_parent=$application_group_id AND ag.idapplication_group=agag.application_group_idapplication_group_child ORDER BY ag.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_network_groups_in_network_group($network_group_id) {

      $ret_array = array();
      $query = "SELECT ng.name, ng.idnetwork_group as id FROM inventory.network_group ng, inventory.network_group_network_group ngng WHERE ngng.network_group_idnetwork_group_parent=$network_group_id AND ng.idnetwork_group=ngng.network_group_idnetwork_group_child ORDER BY ng.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_database_groups_in_database_group($database_group_id) {

      $ret_array = array();
      $query = "SELECT dg.name, dg.iddatabase_group as id FROM inventory.database_group dg, inventory.database_group_database_group dgdg WHERE dgdg.database_group_iddatabase_group_parent=$database_group_id AND dg.iddatabase_group=dgdg.database_group_iddatabase_group_child ORDER BY dg.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_databases_in_database_group($database_group_id) {

      $ret_array = array();
      $query = "SELECT d.*, d.iddatabase as id FROM inventory.database d, inventory.database_group_database dgd WHERE dgd.database_group_iddatabase_group=$database_group_id AND dgd.database_iddatabase=d.iddatabase ORDER BY d.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_environment_groups_in_environment_group($environment_group_id) {

      $ret_array = array();
      $query = "SELECT eg.name, eg.idenvironment_group as id FROM inventory.environment_group eg, inventory.environment_group_environment_group egeg WHERE egeg.environment_group_idenvironment_group_parent=$environment_group_id AND eg.idenvironment_group=egeg.environment_group_idenvironment_group_child ORDER BY eg.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_environments_in_environment_group($environment_group_id) {

      $ret_array = array();
      $query = "SELECT e.*, e.idenvironment as id FROM inventory.environment e, inventory.environment_group_environment ege WHERE ege.environment_group_idenvironment_group=$environment_group_id AND ege.environment_idenvironment=e.idenvironment ORDER BY e.name";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function get_server_properties($server_id) {

      $ret_array = array();
      $query = "SELECT s.name, s.description FROM asc.ci_server WHERE s.name=\"".$server."\"";
      return pg_fetch_all(pg_query($query));

    }

    public function kb_get_workorder_status($lwo_id) {

      $ret_array = array();
      $query = "select status from appmgmt.workorder where wo_id=".$lwo_id;
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
        $ret_status = $ret_array[0][0];
      }
      return $ret_status;

    }

    public function kb_get_woid_schedule($wo_id) {

      $ret_array = array();
      $query = "select p_wo_id, p_status from appmgmt.wo_scheduler where wo_id=".$wo_id;
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function kb_get_full_wo_scheduler() {

      $ret_array = array();
      $query = "select * from appmgmt.wo_scheduler";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function kb_get_wo_detail($wo_id) {

      $ret_array = array();
      $query = "select wo.wo_id as wo_id ,wo.request_user as request_user, ctl.protocol as protocol, ser.name as name, app.app_home as app_home, app.app_user as app_user, ctl.script as script, act.arguments as arguments from appmgmt.ctl_scripts ctl , appmgmt.app_action act,appmgmt.workorder wo,appmgmt.server ser,appmgmt.application app where wo.application_id=app.id and wo.server_id=ser.id and wo.action_id=act.id and act.script_id=ctl.id and wo_id=".$wo_id;
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;

    }

    public function kb_wo_log_update($wo_id,$logmsg) {

      $query = "insert into appmgmt.wo_log (wo_id,insert_time,message) values(".$wo_id.",NOW(),'".$logmsg."');";
      $result = pg_query($query);
      return true;

    }

    public function kb_wo_status_update($wo_id,$status) {

      $query = "update appmgmt.workorder set status='".$status."' where wo_id=".$wo_id;
      $result = pg_query($query);
      return true;

    }

    public function kb_wo_update_pid($wo_id,$pid) {

      $query = "update appmgmt.workorder set pid='".$pid."' where wo_id=".$wo_id;
      $result = pg_query($query);
      return true;

    }

    public function kb_get_wo_servername($wo_id) {

      $query = "select s.name from appmgmt.server s, appmgmt.workorder w where s.id=w.server_id and w.wo_id=".$wo_id;
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
        $ret_name = $ret_array[0][0];
      }
      return $ret_name;

    }

    public function get_deployment_file_list($application_id, $build_id, $environment_id) {

      $ret_array = array();

      $query = "SELECT f.idfile, f.file_name, f.file_type_idfile_type, f.execution_control_idexecution_control, (SELECT fstt.table_name FROM file.file_system_type_table fstt WHERE fstt.idfile_system_type_table=f.file_system_type_table_idfile_system_type_table) AS table_name FROM file.file f, file.file_application fa, file.file_base fbase WHERE f.idfile=fbase.file_idfile AND fa.file_idfile=f.idfile AND fa.application_idapplication=$application_id";
      $query .= " UNION SELECT f.idfile, f.file_name, f.file_type_idfile_type, f.execution_control_idexecution_control, (SELECT fstt.table_name FROM file.file_system_type_table fstt WHERE fstt.idfile_system_type_table=f.file_system_type_table_idfile_system_type_table) AS table_name FROM file.file f, file.file_application fa, file.file_build fb WHERE f.idfile=fb.file_idfile AND fa.file_idfile=f.idfile AND fa.application_idapplication=$application_id AND fb.build_idbuild=$build_id";
      $query .= " UNION SELECT f.idfile, f.file_name, f.file_type_idfile_type, f.execution_control_idexecution_control, (SELECT fstt.table_name FROM file.file_system_type_table fstt WHERE fstt.idfile_system_type_table=f.file_system_type_table_idfile_system_type_table) AS table_name FROM file.file f, file.file_application fa, file.file_environment fe WHERE f.idfile=fe.file_idfile AND fa.file_idfile=f.idfile AND fa.application_idapplication=$application_id AND fe.environment_idenvironment=$environment_id";
      $query .= " UNION SELECT f.idfile, f.file_name, f.file_type_idfile_type, f.execution_control_idexecution_control, (SELECT fstt.table_name FROM file.file_system_type_table fstt WHERE fstt.idfile_system_type_table=f.file_system_type_table_idfile_system_type_table) AS table_name FROM file.file f, file.file_application fa, file.file_build_environment fbe WHERE f.idfile=fbe.file_idfile AND fa.file_idfile=f.idfile AND fa.application_idapplication=$application_id AND fbe.build_idbuild=$build_id AND fbe.environment_idenvironment=$environment_id";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $row2 = array();
        if ($row['execution_control_idexecution_control']) {
          $query2 = "SELECT * FROM file.execution_control ec, file.execution_function ef WHERE ec.idexecution_control=".$row['execution_control_idexecution_control']." AND ec.execution_function_idexecution_function=ef.idexecution_function";
          $result2 = pg_query($query2);
          $row2 = pg_fetch_array($result2);
        }
        $ret_array[] = array_merge($row, $row2);
      }
      return $ret_array;
 
    }

    public function get_deployment_file_system_info ($file_system_table, $file_id) {

      $ret_array = array();
      $query = "SELECT fst.* FROM file.$file_system_table fst WHERE fst.file_idfile=$file_id";
      $result = pg_query($query);
      while ($row = pg_fetch_array($result)) {
        $ret_array[] = $row;
      }
      return $ret_array;
 
    }

  }


  function database_pgsql_fetch_value($result) {

    $row = array();

    pg_result_seek($result, 0);

    if ($result) {
      $row = pg_fetch_array($result, NULL, PGSQL_NUM);
      return $row[0];
    }
    return $row;

  }

  function database_get_root_cis() {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_root_cis): Passed parameter: none", 0);

    $ret_array = array();

    $query = "SELECT r.guid, t.ci_table, t.name, t.icon FROM asc.relationship r, asc.guid g, asc.type t WHERE r.parent_guid IS NULL AND g.id=r.guid AND g.type_id=t.id ORDER BY t.name";
    $rows = pg_fetch_all(pg_query($query));

    foreach($rows as $row) {
      $query = "SELECT c.name FROM ".$row['ci_table']." c WHERE id=".$row['guid'];
      $ci_name = database_pgsql_fetch_value(pg_query($query));
      $row['ci_name'] = $ci_name;

      $row['has_children'] = TRUE;
      $query = "SELECT * FROM asc.dependency d WHERE d.parent_guid=".$row['guid'];
      if (pg_num_rows(pg_query($query)) == 0) {
        $row['has_children'] = FALSE;
      }

      array_push($ret_array, $row);
    }

    return $ret_array;

  }

  function database_get_has_unmanaged_cis () {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_has_unmanaged_cis): Passed parameter: none", 0);

    $query = "SELECT g.id FROM asc.guid g WHERE NOT EXISTS (SELECT d.id FROM asc.dependency d WHERE g.id=d.guid)";
    if (pg_num_rows(pg_query($query)) > 0) {
      return TRUE;
    }
    return FALSE;

  }

  function database_get_unmanaged_cis() {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_unmanaged_cis): Passed parameter: none", 0);

    $ret_array = array();
    $query = "SELECT g.id, t.ci_table, t.name, t.icon FROM asc.guid g, asc.type t WHERE NOT EXISTS (SELECT d.id FROM asc.dependency d WHERE g.id=d.guid) AND g.type_id=t.id ORDER BY t.name";
    $rows = pg_fetch_all(pg_query($query));

    foreach($rows as $row) {
      $row['guid'] = $row['id'];

      $query = "SELECT c.name FROM ".$row['ci_table']." c WHERE id=".$row['id'];
      $ci_name = database_pgsql_fetch_value(pg_query($query));
      $row['ci_name'] = $ci_name;

      $row['has_children'] = TRUE;
      $query = "SELECT * FROM asc.dependency d WHERE d.parent_guid=".$row['guid'];
      if (pg_num_rows(pg_query($query)) == 0) {
        $row['has_children'] = FALSE;
      }

      array_push($ret_array, $row);
    }

    return $ret_array;

  }

  function database_get_property_cis($guid) {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_property_cis): Passed parameter: guid=$guid", 0);

    $ret_array = array();

    $query = "SELECT p.guid, t.ci_table, t.name, t.icon FROM asc.property p, asc.guid g, asc.type t WHERE p.parent_guid=".$guid." AND p.guid=g.id AND g.type_id=t.id ORDER BY t.name";
    $rows = pg_fetch_all(pg_query($query));

    foreach($rows as $row) {
      $query = "SELECT c.name FROM ".$row['ci_table']." c WHERE id=".$row['guid'];
      $ci_name = database_pgsql_fetch_value(pg_query($query));
      $row['ci_name'] = $ci_name;

      $row['has_children'] = TRUE;
      $query = "SELECT * FROM asc.property p WHERE p.parent_guid=".$row['guid'];
      if (pg_num_rows(pg_query($query)) == 0) {
        $row['has_children'] = FALSE;
      }

      array_push($ret_array, $row);
    }

    return $ret_array;

  }

  function database_get_children_cis($guid) {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_children_cis): Passed parameter: none", 0);

    $ret_array = array();

    $query = "SELECT d.guid, t.ci_table, t.name, t.icon FROM asc.dependency d, asc.guid g, asc.type t WHERE d.parent_guid=".$guid." AND d.guid=g.id AND g.type_id=t.id ORDER BY t.name";
    $rows = pg_fetch_all(pg_query($query));

    foreach($rows as $row) {
      $query = "SELECT c.name FROM ".$row['ci_table']." c WHERE id=".$row['guid'];
      $ci_name = database_pgsql_fetch_value(pg_query($query));
      $row['ci_name'] = $ci_name;

      $row['has_children'] = TRUE;
      $query = "SELECT * FROM asc.dependency d WHERE d.parent_guid=".$row['guid'];
      if (pg_num_rows(pg_query($query)) == 0) {
        $row['has_children'] = FALSE;
      }

      array_push($ret_array, $row);
    }

    return $ret_array;

  }

  function database_get_types() {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_types): Passed parameter: none", 0);

    $ret_array = array();

    $query = "SELECT * FROM asc.type t";
    $ret_array = pg_fetch_all(pg_query($query));
    return $ret_array;

  }

  function database_get_type($guid) {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_type): Passed parameter: guid=$guid", 0);

    $ret_array = array();

    $query = "SELECT * FROM asc.type t, asc.guid g WHERE g.id=".$guid." AND g.type_id=t.id";
    $ret_array = database_pgsql_fetch_rowarr(pg_query($query));
    return $ret_array;

  }

  function database_get_ci($guid) {
    global $debug, $self;
    if ($debug) error_log("$self(database_get_ci): Passed parameter: guid=$guid", 0);

    $ret_array = array();

    $query = "SELECT g.id, t.ci_table, t.name, t.icon FROM asc.guid g, asc.type t WHERE g.id=".$guid." AND g.type_id=t.id";
    $ret_array = database_pgsql_fetch_rowarr(pg_query($query), MYSQL_ASSOC);
    $query = "SELECT * from ".$ret_array['ci_table']." c WHERE id=".$guid;
    $ret_array['ci'] = database_pgsql_fetch_rowarr(pg_query($query), MYSQL_ASSOC);

    return $ret_array;

  }

?>
