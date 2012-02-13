  var minus = new Image();
  minus.src = "/common/images/minusico.png";
  var plus = new Image();
  plus.src = "/common/images/plusico.png";
  var g_selected_node = "";

  function server_group_explorer_expand_item(objNode) {

    if (objNode.getAttribute("expanded") == "false") {
      objNode.style.visibility = "hidden";
      objNode.setAttribute("preexpandedinnerHTML", objNode.innerHTML);
      if (xmlhttp) {
        switch (objNode.getAttribute("item_type")) {
          case "server_group":
            var url = "/server_group_explorer_frames/expand_server_group.php?id="+objNode.getAttribute("item_id")+"&indent="+objNode.getAttribute("item_indent");
            break;
          case "server":
            var url = "/server_group_explorer_frames/expand_server.php?id="+objNode.getAttribute("item_id")+"&indent="+objNode.getAttribute("item_indent");
            break;
          case "directory":
            var url = "/server_group_explorer_frames/expand_directory.php?id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&indent="+objNode.getAttribute("item_indent");
            break;
        }
        xmlhttp.open("GET", url, true);
        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
              objNode.innerHTML = objNode.innerHTML + "<br />" + xmlhttp.responseText; 
              objNode.setAttribute("expanded", "true");
            } else {
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
      if ((objNode.getAttribute("preexpandedinnerHTML") == null) || (objNode.getAttribute("preexpandedinnerHTML") == "")) {
        objNode.setAttribute("preexpandedinnerHTML", objNode.innerHTML.substring(0, objNode.innerHTML.toLowerCase().indexOf("<br")));
      }
      objNode.innerHTML = objNode.getAttribute("preexpandedinnerHTML");
      eval("document.getElementById(\""+objNode.id+"expand\").src=plus.src");
      objNode.setAttribute("expanded", "false");
    }

  }

  function server_group_explorer_open_item(objNode) {

    objPathListBox = top.document.getElementById("path");
    if (objPathListBox) {
      if (objNode.getAttribute("item_type") == 'directory' || objNode.getAttribute("item_type") == 'file') {
        for (i = 0; i < objPathListBox.options.length; i++) {
          if (objPathListBox.options[i].value == objNode.getAttribute("item_path")) {
            objPathListBox.options.selectedIndex = i;
            break;
          }
        }
        if (i == objPathListBox.options.length) {
          objPathListBox.options[i] = new Option(objNode.getAttribute("item_path"), objNode.getAttribute("item_path"));
        }
        objPathListBox.options.selectedIndex = i;
      }
    }

    objServerListBox = top.document.getElementById("server");
    if (objServerListBox) {
      if (objNode.getAttribute("item_type") == 'server_group' || objNode.getAttribute("item_type") == 'server') {
        for (i = 0; i < objServerListBox.options.length; i++) {
          if (objServerListBox.options[i].value == objNode.getAttribute("item_id")) {
            objServerListBox.options.selectedIndex = i;
            break;
          }
        }
        if (i == objServerListBox.options.length) {
          objServerListBox.options[i] = new Option(objNode.getAttribute("item_id"), objNode.getAttribute("item_name"));
        }
        objServerListBox.options.selectedIndex = i;
      }
    }

    if (top.output_frame) {
      switch (objNode.getAttribute("item_type")) {
        case "server_group":
          top.output_frame.document.location.href = "/server_group_explorer_frames/show_server_group.php?server_group_id="+objNode.getAttribute("item_id");
          break;
        case "server":
          top.output_frame.document.location.href = "/server_group_explorer_frames/show_server.php?server_id="+objNode.getAttribute("item_id");
          break;
        case "directory":
          top.output_frame.document.location.href = "/list_files/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"));
          break;
        case "file":
          top.output_frame.document.location.href = "/file_viewer_frames/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&tail=false";
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

  function server_group_explorer_list_processes(objNode) {

    if (top.output_frame) {
      top.output_frame.document.location.href = "/server_group_explorer_frames/list_processes.php?server_id="+objNode.getAttribute("item_id");
    }

  }

  function server_group_explorer_tail_file (objNode) {

    if (top.output_frame) {
      top.output_frame.document.location.href = "/file_viewer_frames/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&tail=true";
    }

    if (g_selected_node != null) {
      if (g_selected_node != "") {
        objPrevNode = document.getElementById(g_selected_node);
        if (objPrevNode != null) {
          objPrevNode.className = objPrevNode.className.replace(/ selected/g, ""
);
        }
      }
    }
    g_selected_node = objNode.id+"href3";
    objThisNode = document.getElementById(g_selected_node);
    objThisNode.className = objThisNode.className+" selected";

  }

  function server_group_explorer_show_properties(type, server_id, path) {

    switch (type) {
      case "server":
        var url = "/server_group_explorer_frames/show_server_properties.php?type="+type+"&server_id="+server_id;
        break;
      case "directory":
        var url = "/server_group_explorer_frames/show_directory_properties.php?type="+type+"&server_id="+server_id+"&path="+path;
        break;
      case "file":
        var url = "/server_group_explorer_frames/show_file_properties.php?type="+type+"&server_id="+server_id+"&path="+path;
        break;
    }

    window.open(url, "_blank", "resizable=1, height=450px, width=300px");

  }

  function server_group_explorer_explore_from_here(objNode) {

    switch (objNode.getAttribute("item_type")) {
      case "server_group":
        document.location.href = "/server_group_explorer_frames/index.php?server_group_ids="+objNode.getAttribute("item_id");
        break;
      case "server":
        document.location.href = "/file_explorer/index.php?ids="+objNode.getAttribute("item_id");
        break;
    }

  }

  var g_search_panel_height = 290;

  function server_group_explorer_toggle_search() {

    if (document.getElementById("search_panel_toggle_bar").className.indexOf("show") == -1) {
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className.replace(" colapsed", "");
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className+" show";
      document.getElementById("search_panel_toggle_area").style.display="block";
      top.document.getElementById("left_frame").rows = "*, 290";
    } else {
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className.replace(" show", "");
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className+" colapsed";
      document.getElementById("search_panel_toggle_area").style.display="none";
      top.document.getElementById("left_frame").rows = "*, 10";
    }

  }

  function search_view_toggle_date() {

    objDiv = document.getElementById("date_panel");
    if (objDiv.style.display == "none") {
      g_search_panel_height += 126;
      objDiv.style.display = "block";
    } else {
      g_search_panel_height -= 126;
      objDiv.style.display = "none";
    }
    document.getElementById("search_panel_panel").rows = "*, "+g_search_panel_height;

  }

  function search_view_toggle_size() {

    objDiv = document.getElementById("size_panel");
    if (objDiv.style.display == "none") {
      g_search_panel_height += 109;
      objDiv.style.display = "block";
    } else {
      g_search_panel_height -= 109;
      objDiv.style.display = "none";
    }
    document.getElementById("search_panel_panel").rows = "*, "+g_search_panel_height;

  }

