
  function server_group_administration_edit_server_group() {

    var objSelect = document.getElementById("server_group_list");
    var server_group_id = objSelect.options[objSelect.selectedIndex].value;
    document.location = "/server_group_administration/edit_server_group.php?server_group_id="+server_group_id;

  }

  function server_group_administration_update_server_group(server_group_id) {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var description = document.getElementById("description").value;
    var objSelect = document.getElementById("parent_server_group");
    var parent_server_group_id = objSelect.options[objSelect.selectedIndex].value;
    if (xmlhttp) {
      var url = "/server_group_administration/update_server_group.php?server_group_id="+server_group_id+"&description="+description+"&parent_server_group_id="+parent_server_group_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            document.location = "/server_group_administration/index.php";
          } else {
            objDiv.innerHTML = "Server group update partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_group_administration_remove_server_group() {

    var objDiv = document.getElementById("status_panel");
    var objSelect = document.getElementById("server_group_list");
    var server_group_id = objSelect.options[objSelect.selectedIndex].value;
    var server_group_name = objSelect.options[objSelect.selectedIndex].text;
    if (confirm("Are you sure you want to remove "+server_group_name)) {
      if (xmlhttp) {
        var url = "/server_group_administration/remove_server_group.php?server_group_id="+server_group_id;
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              document.location = "/server_group_administration/index.php";
            } else {
              alert("Server group removal partially failed");
            }
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_group_administration_add_server_group() {

    document.location = "/server_group_administration/add_server_group.php";

  }

  function server_group_administration_new_server_group() {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var description = document.getElementById("description").value;
    var objSelect = document.getElementById("parent_server_group");
    var parent_server_group_id = objSelect.options[objSelect.selectedIndex].value;
    if (xmlhttp) {
      var url = "/server_group_administration/new_server_group.php?&name="+name+"&description="+description+"&parent_server_group_id="+parent_server_group_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          document.location = "/server_group_administration/index.php";
        }
      }
      xmlhttp.send(null);
    }

  }

  function server_group_administration_cancel_edit_server_group() {

    document.location = "/server_group_administration/index.php";

  }
