
  function path_administration_edit_path() {

    var objSelect = document.getElementById("path_list");
    var path_id = objSelect.options[objSelect.selectedIndex].value;
    document.location = "/path_administration/edit_path.php?path_id="+path_id;

  }

  function path_administration_update_path(path_id) {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var objis_root = document.getElementById("is_root");
    var objis_directory = document.getElementById("is_directory");
    var is_root = "TRUE";
    var is_directory = "TRUE";
    if (!objis_root.checked) {
      is_root = "FALSE";
    }
    if (!objis_directory.checked) {
      is_directory = "FALSE";
    }
    if (xmlhttp) {
      var url = "/path_administration/update_path.php?path_id="+path_id+"&name="+name+"&is_root="+is_root+"&is_directory="+is_directory;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            document.location = "/path_administration/index.php";
          } else {
            objDiv.innerHTML = "Path update partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function path_administration_remove_path() {

    var objDiv = document.getElementById("status_panel");
    var objSelect = document.getElementById("path_list");
    var path_id = objSelect.options[objSelect.selectedIndex].value;
    var path_name = objSelect.options[objSelect.selectedIndex].text;
    var answer = confirm("Are you sure you want to remove "+path_name);
    if (answer) {
      if (xmlhttp) {
        var url = "/path_administration/remove_path.php?path_id="+path_id;
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              document.location = "/path_administration/index.php";
            } else {
              alert("Server removal partially failed");
            }
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function path_administration_add_path() {

    document.location = "/path_administration/add_path.php";

  }

  function path_administration_new_path() {

    var objDiv = document.getElementById("status_panel");
    var name = document.getElementById("name").value;
    var objis_root = document.getElementById("is_root");
    var objis_directory = document.getElementById("is_directory");
    var is_root = "true";
    var is_directory = "true";
    if (!objis_root.checked) {
      is_root = "false";
    }
    if (!objis_directory.checked) {
      is_directory = "false";
    }
    if (xmlhttp) {
      var url = "/path_administration/new_path.php?&name="+name+"&is_root="+is_root+"&is_directory="+is_directory;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          document.location = "/path_administration/index.php";
        }
      }
      xmlhttp.send(null);
    }

  }

  function path_administration_cancel_edit_path() {

    document.location = "/path_administration/index.php";

  }
