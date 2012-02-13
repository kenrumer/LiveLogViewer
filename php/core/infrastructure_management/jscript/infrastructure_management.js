  var minus = new Image();
  minus.src = "/common/images/minusico.png";
  var plus = new Image();
  plus.src = "/common/images/plusico.png";
  var g_selected_node = "";
  var g_selected_menu = "infrastructure_management_nav_menu_groups";
  var g_selected_row = "";

  function infrastructure_management_expand_item(objNode) {

    if (objNode.getAttribute("expanded") == "false") {
      objNode.style.visibility = 'hidden';
      objNode.setAttribute("preexpandedinnerHTML", objNode.innerHTML);
      if (xmlhttp) {
        var url = "/infrastructure_management/expand_item.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id")+"&indent="+objNode.getAttribute("item_indent")+"&table="+objNode.getAttribute("item_table");
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              objNode.innerHTML = objNode.innerHTML + "<br />" + xmlhttp.responseText;
              objNode.setAttribute("expanded", "true");
            }  else {
              objNode.innerHTML = objNode.getAttribute("preexpandedinnerHTML");
              objNode.setAttribute("expanded", "false");
            }
            eval("document.getElementById(\""+objNode.id+"expand\").src=minus.src");
            objNode.style.visibility='visible';
          }
        }
        xmlhttp.send(null);
      }
    } else {
      objNode.innerHTML = objNode.getAttribute("preexpandedinnerHTML");
      eval("document.getElementById(\""+objNode.id+"expand\").src=plus.src");
      objNode.setAttribute("expanded", "false");
    }

  }

  function infrastructure_management_show_item_list(objNode) {

    var output_frame = top.document.getElementById('output_frame');
    if (output_frame) {
      switch (objNode.getAttribute("item_type")) {
        case "my_server_group":
        case "server_group":
        case "my_application_group":
        case "application_group":
        case "my_database_group":
        case "database_group":
        case "my_network_group":
        case "network_group":
          output_frame.src = "show_item_list.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id");
          break;
        case "server":
        case "application":
        case "database":
        case "network":
          output_frame.src = "show_item_details.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id");
          break;
        case "asc_administration":
          output_frame.src = "/asc_administration/index.php";
          break;
        case "server_administration":
          output_frame.src = "/server_administration/index.php";
          break;
        case "user_administration":
          output_frame.src = "/user_administration/index.php";
          break;
        case "agent_administration":
          output_frame.src = "/agent_administration/index.php";
          break;
        case "path_administration":
          output_frame.src = "/path_administration/index.php";
          break;
      }
    }

    if (g_selected_node != null) {
      if (g_selected_node != "") {
        objPrevNode = document.getElementById(g_selected_node);
        if (objPrevNode != null) {
          objPrevNode.className = objPrevNode.className.replace(/ selected/g, "");
        }
      }
    }
    g_selected_node = objNode.id+"href3";
    objThisNode = document.getElementById(g_selected_node);
    if (objThisNode) {
      objThisNode.className = objThisNode.className+" selected";
    }

  }

  function infrastructure_management_show_item_details(objRow) {

    var details_frame = document.getElementById('details_frame');
    if (details_frame) {
      details_frame.src = "show_item_details.php?type="+objRow.getAttribute("item_type")+"&id="+objRow.getAttribute("item_id");
    }

    if (g_selected_row != "") {
      objPrevRow = document.getElementById(g_selected_row);
      objPrevRow.className = objPrevRow.className.replace(/ selected/g, "");
    }
    g_selected_row = objRow.id;
    objThisRow = document.getElementById(g_selected_row);
    objThisRow.className = objThisRow.className+" selected";

  }

  function infrastructure_management_open_item(objNode) {

    switch (objNode.getAttribute("item_type")) {
      case "my_server_group":
      case "server_group":
        window.open("/file_explorer/index.php?server_group="+objNode.getAttribute("item_id"), "_blank", "height=600,width=800,menubar=1,resizable=1,status=1,scrollbars=1,toolbar=1,location=1");
        break;
      case "my_server":
      case "server":
        window.open("/file_explorer/index.php?ids="+objNode.getAttribute("item_id"), "_blank", "height=600,width=800,menubar=1,resizable=1,status=1,scrollbars=1,toolbar=1,location=1");
        break;
    }

  }

  function infrastructure_management_search_items(name, type) {

    if (g_selected_menu != "") {
      objSelNode = document.getElementById(g_selected_menu);
      objSelNode.className = objSelNode.className.replace(/ selected/g, "");
    }
    if (xmlhttp) {
      var url = "/infrastructure_management/show_item_search_results.php?type="+type+"&name="+name;
      var objMenu = document.getElementById("menu_panel");
      if (objMenu) {
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              objMenu.innerHTML = xmlhttp.responseText;
            }
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_set_selected(objNode) {

    if (g_selected_menu != "") {
      objSelNode = document.getElementById(g_selected_menu);
      objSelNode.className = objSelNode.className.replace(/ selected/g, "");
    }
    g_selected_menu = objNode.id;
    objNode.className = objNode.className+" selected";

    var item_url = objNode.getAttribute("item_page");
    var output_frame = top.document.getElementById('output_frame');
    if (output_frame) {
      output_frame.src = item_url;
    }

    if (xmlhttp) {
      var menu_url = objNode.getAttribute("item_menu");
      var objMenu = document.getElementById("menu_panel");
      if (objMenu) {
        xmlhttp.open("GET", menu_url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              objMenu.innerHTML = xmlhttp.responseText;
            }
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_create_group(objNode) {

    var strGroupName = prompt("Enter the name of the new group");
    objNode.style.visibility = 'hidden';
    if (xmlhttp) {
      var url = "/infrastructure_management/add_item.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id")+"&indent="+objNode.getAttribute("item_indent")+"&name="+strGroupName;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            if (objNode.getAttribute("expanded") == "true") {
              objNode.innerHTML = objNode.innerHTML + xmlhttp.responseText;
            }
          } else {
            alert("Failed to created the new group");
          }
          objNode.style.visibility='visible';
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_remove_my_group(objNode) {

    objNode.style.visibility = 'hidden';
    if (xmlhttp) {
      var url = "/infrastructure_management/remove_my_item.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id")+"&parent_id="+objNode.parentNode.getAttribute("item_id");
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objNode.style.display = 'none';
          } else {
            objNode.style.visibility = 'visible';
            alert("Failed to remove the group");
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_remove_group(objNode) {

    objNode.style.visibility = 'hidden';
    if (xmlhttp) {
      var url = "/infrastructure_management/remove_item.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id");
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objNode.style.display = 'none';
          } else {
            objNode.style.visibility = 'visible';
            alert("Failed to remove the group");
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_add_item_to_item_group(objNode) {

    window.open("/infrastructure_management/add_item_to_group.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id"), "_blank", "height=340,width=600,menubar=0,resizable=0,status=0,scrollbars=0,toolbar=0,location=1");

  }

  function infrastructure_management_add_path_to_server(objNode) {

    window.open("/infrastructure_management/add_path_to_server.php?id="+objNode.getAttribute("item_id"), "_blank", "height=635,width=600,menubar=0,resizable=0,status=0,scrollbars=0,toolbar=0,location=1");

  }

  function infrastructure_management_remove_item_from_group (objNode) {

    if (xmlhttp) {
      var url = "/infrastructure_management/remove_item.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id");
      xmlhttp.open("GET", url, false);
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_add_item_to_item_group2 (type, id) {

    objItemsInGroup = document.getElementById("items_in_group");
    if (xmlhttp) {
      var url = "/infrastructure_management/remove_all_items.php?type="+type+"&id="+id;
      xmlhttp.open("GET", url, false);
      xmlhttp.send(null);
      for (var i = 0; i < objItemsInGroup.options.length; i++) {
        url = "/infrastructure_management/add_item2.php?type="+type+"&id="+id+"&add_id="+objItemsInGroup.options[i].value;
        xmlhttp.open("GET", url, false);
        xmlhttp.send(null);
      }
      window.close();
    }

  }

  function infrastructure_management_add_path_to_server2 (id) {

    objItemsInGroup = document.getElementById("items_in_group");
    objDeniedItemsInGroup = document.getElementById("denied_items_in_group");
    if (xmlhttp) {
      var url = "/infrastructure_management/remove_all_paths.php?server_id="+id;
      xmlhttp.open("GET", url, false);
      xmlhttp.send(null);
      for (var i = 0; i < objItemsInGroup.options.length; i++) {
        url = "/infrastructure_management/add_path2.php?server_id="+id+"&add_id="+objItemsInGroup.options[i].value;
        xmlhttp.open("GET", url, false);
        xmlhttp.send(null);
      }
      for (var i = 0; i < objDeniedItemsInGroup.options.length; i++) {
        url = "/infrastructure_management/add_path3.php?server_id="+id+"&add_id="+objDeniedItemsInGroup.options[i].value;
        xmlhttp.open("GET", url, false);
        xmlhttp.send(null);
      }
      window.close();
    }

  }

  function infrastructure_management_add_to_my_server_group(objNode) {

    objNode.style.visibility = 'hidden';
    if (xmlhttp) {
      var url = "/infrastructure_management/add_item_to_my_group.php?type="+objNode.getAttribute("item_type")+"&id="+objNode.getAttribute("item_id");
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objNode.style.visibility = 'visible';
          } else {
            objNode.style.visibility = 'visible';
            alert("Failed to add to my group");
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function infrastructure_management_denied_move_item() {

    var objAvailableItems = document.getElementById("denied_available_items");
    var objItemsInGroup = document.getElementById("denied_items_in_group");
    for (var i = 0; i < objAvailableItems.options.length; i++) {
      if (objAvailableItems.options[i].selected) {
        var objOption = document.createElement("OPTION");
        objOption.text = objAvailableItems.options[i].text;
        objOption.value = objAvailableItems.options[i].value;
        objItemsInGroup.options.add(objOption, objItemsInGroup.options.length);
        objAvailableItems.remove(i);
        i--;
      }
    }

  }

  function infrastructure_management_move_item() {

    var objAvailableItems = document.getElementById("available_items");
    var objItemsInGroup = document.getElementById("items_in_group");
    for (var i = 0; i < objAvailableItems.options.length; i++) {
      if (objAvailableItems.options[i].selected) {
        var objOption = document.createElement("OPTION");
        objOption.text = objAvailableItems.options[i].text;
        objOption.value = objAvailableItems.options[i].value;
        objItemsInGroup.options.add(objOption, objItemsInGroup.options.length);
        objAvailableItems.remove(i);
        i--;
      }
    }

  }

  function infrastructure_management_denied_remove_item() {

    var objItemsInGroup = document.getElementById("denied_items_in_group");
    var objAvailableItems = document.getElementById("denied_available_items");
    for (var i = 0; i < objItemsInGroup.options.length; i++) {
      if (objItemsInGroup.options[i].selected) {
        var objOption = document.createElement("OPTION");
        objOption.text = objItemsInGroup.options[i].text;
        objOption.value = objItemsInGroup.options[i].value;
        objAvailableItems.options.add(objOption, objAvailableItems.options.length);
        objItemsInGroup.remove(i);
        i--;
      }
    }

  }

  function infrastructure_management_remove_item() {

    var objItemsInGroup = document.getElementById("items_in_group");
    var objAvailableItems = document.getElementById("available_items");
    for (var i = 0; i < objItemsInGroup.options.length; i++) {
      if (objItemsInGroup.options[i].selected) {
        var objOption = document.createElement("OPTION");
        objOption.text = objItemsInGroup.options[i].text;
        objOption.value = objItemsInGroup.options[i].value;
        objAvailableItems.options.add(objOption, objAvailableItems.options.length);
        objItemsInGroup.remove(i);
        i--;
      }
    }

  }
