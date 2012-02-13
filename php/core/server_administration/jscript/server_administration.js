
  function server_administration_edit_server() {

    var objSelect = document.getElementById("server_list");
    var server_id = objSelect.options[objSelect.selectedIndex].value;
    document.location = "/server_administration/edit_server.php?server_id="+server_id;

  }

  function server_administration_update_server(server_id) {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var hostname = document.getElementById("hostname").value;
    var os = document.getElementById("os").value;
    var facility = document.getElementById("facility").value;
    var service_tag = document.getElementById("service_tag").value;
    var end_of_service_life = document.getElementById("end_of_service_life").value;
    if (xmlhttp) {
      var url = "/server_administration/update_server.php?server_id="+server_id+"&name="+name+"&hostname="+hostname+"&os="+os+"&facility="+facility+"&service_tag="+service_tag+"&end_of_service_life="+end_of_service_life;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            document.location = "/server_administration/index.php";
          } else {
            objDiv.innerHTML = "Server update partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_administration_remove_server_group(server_id, server_group_id) {

    var objDiv = document.getElementById("status_panel");
    if (xmlhttp) {
      var url = "/server_administration/remove_server_group.php?server_id="+server_id+"&server_group_id="+server_group_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            alert("Server group removed");
          } else {
            objDiv.innerHTML = "Server group removal partially failed";
          }
        }
      }
    }
    xmlhttp.send(null);

  }

  function server_administration_remove_path(server_id, path_id) {

    var objDiv = document.getElementById("status_panel");
    if (xmlhttp) {
      var url = "/server_administration/remove_path.php?server_id="+server_id+"&path_id="+path_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            alert("Path removed");
          } else {
            objDiv.innerHTML = "Path removal partially failed";
          }
        }
      }
    }
    xmlhttp.send(null);

  }

  function server_administration_remove_server() {

    var objDiv = document.getElementById("status_panel");
    var objSelect = document.getElementById("server_list");
    var server_id = objSelect.options[objSelect.selectedIndex].value;
    var server_name = objSelect.options[objSelect.selectedIndex].text;
    if (confirm("Are you sure you want to remove "+server_name)) {
      if (xmlhttp) {
        var url = "/server_administration/remove_server.php?server_id="+server_id;
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              document.location = "/server_administration/index.php";
            } else {
              alert("Server removal partially failed");
            }
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_administration_add_server() {

    document.location = "/server_administration/add_server.php";

  }

  function server_administration_add_path(server_id) {

    var objDiv = document.getElementById("status_panel");
    var objSelect = document.getElementById("paths_list");
    var path_id = objSelect.options[objSelect.selectedIndex].value;
    if (xmlhttp) {
      var url = "/server_administration/add_path.php?server_id="+server_id+"&path_id="+path_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            alert("Path added");
          } else {
            objDiv.innerHTML = "Server update partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_administration_add_server_group(server_id) {

    var objDiv = document.getElementById("status_panel");
    var objSelect = document.getElementById("server_groups_list");
    var server_group_id = objSelect.options[objSelect.selectedIndex].value;
    if (xmlhttp) {
      var url = "/server_administration/add_server_group.php?server_id="+server_id+"&server_group_id="+server_group_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            alert("Path added");
          } else {
            objDiv.innerHTML = "Server update partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_administration_new_server() {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var hostname = document.getElementById("hostname").value;
    var fqdn = document.getElementById("fqdn").value;
    var primary_ip = document.getElementById("primary_ip").value;
    var os = document.getElementById("os").value;
    var facility = document.getElementById("facility").value;
    var service_tag = document.getElementById("service_tag").value;
    var end_of_service_life = document.getElementById("end_of_service_life").value;
    var objos_type = document.getElementById("os_type_win");
    var os_type = "unix";
    if (objos_type.checked) {
      os_type = "win";
    }
    if (xmlhttp) {
      var url = "/server_administration/new_server.php?&name="+name+"&hostname="+hostname+"&fqdn="+fqdn+"&primary_ip="+primary_ip+"&os="+os+"&facility="+facility+"&service_tag="+service_tag+"&end_of_service_life="+end_of_service_life+"&os_type="+os_type;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          document.location = "/server_administration/index.php";
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_administration_cancel_edit_server() {

    document.location = "/server_administration/index.php";

  }
