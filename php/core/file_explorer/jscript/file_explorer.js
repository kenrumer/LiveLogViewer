  var minus = new Image();
  minus.src = "/common/images/minusico.png";
  var plus = new Image();
  plus.src = "/common/images/plusico.png";
  var g_selected_node = "";

  function file_explorer_expand_item(objNode) {

    if (objNode.getAttribute("expanded") == "false") {
      objNode.style.visibility = "hidden";
      objNode.setAttribute("preexpandedinnerHTML", objNode.innerHTML);
      if (xmlhttp) {
        switch (objNode.getAttribute("item_type")) {
          case "server":
            var url = "/file_explorer/expand_server.php?id="+objNode.getAttribute("item_id")+"&indent="+objNode.getAttribute("item_indent");
            break;
          case "directory":
            var url = "/file_explorer/expand_directory.php?id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&indent="+objNode.getAttribute("item_indent");
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

  function file_explorer_open_item(objNode) {

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
      for (i = 0; i < objServerListBox.options.length; i++) {
        if (objServerListBox.options[i].value == objNode.getAttribute("item_id")) {
          objServerListBox.options.selectedIndex = i;
          break;
        }
      }
    }

    if (top.output_frame) {
      switch (objNode.getAttribute("item_type")) {
        case "server":
          top.output_frame.document.location.href = "/file_explorer/show_server.php?server_id="+objNode.getAttribute("item_id");
          break;
        case "directory":
          top.output_frame.document.location.href = "/list_files/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"));
          break;
        case "file":
          top.output_frame.document.location.href = "/file_viewer/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&tail=false";
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

  function file_explorer_tail_file (objNode) {

    if (top.output_frame) {
      top.output_frame.document.location.href = "/file_viewer/index.php?server_id="+objNode.getAttribute("item_id")+"&path="+escape(objNode.getAttribute("item_path"))+"&tail=true";
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

  function file_explorer_show_properties(type, server_id, path) {

    switch (type) {
      case "server":
        var url = "/file_explorer/show_server_properties.php?type="+type+"&server_id="+server_id;
        break;
      case "directory":
        var url = "/file_explorer/show_directory_properties.php?type="+type+"&server_id="+server_id+"&path="+path;
        break;
      case "file":
        var url = "/file_explorer/show_file_properties.php?type="+type+"&server_id="+server_id+"&path="+path;
        break;
    }

    window.open(url, "_blank", "resizable=1, height=450px, width=300px");

  }

  function file_explorer_explore_item(objNode) {

    document.location.href = "/file_explorer/index.php?ids="+objNode.getAttribute("item_id")+"&paths="+escape(objNode.getAttribute("item_path"));

  }

  var g_search_panel_height = 300;

  function file_explorer_toggle_search() {

    if (document.getElementById("search_panel_toggle_bar").className.indexOf("show") == -1) {
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className.replace(" colapsed", "");
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className+" show";
      document.getElementById("search_panel_toggle_area").style.display="block";
      document.getElementById("search_panel_panel").style.height=g_search_panel_height+"px";
      var new_height = g_search_panel_height+5;
      document.getElementById("folder_panel_panel").style.bottom=new_height+"px";
    } else {
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className.replace(" show", "");
      document.getElementById("search_panel_toggle_bar").className = document.getElementById("search_panel_toggle_bar").className+" colapsed";
      document.getElementById("search_panel_toggle_area").style.display="none";
      document.getElementById("search_panel_panel").style.height="15px";
      document.getElementById("folder_panel_panel").style.bottom="20px";
    }

  }

  function file_explorer_close_date_picker() {

    objDiv = document.getElementById('calendar');
    if (objDiv) { objDiv.style.display = 'none'; }

  }

  function file_explorer_show_date_picker(id) {
    //var newX, newY;


    //objDiv = document.getElementById('calendar');
    //if (objDiv) {
      //divX = x - parseInt(document.all?document.documentElement.scrollLeft:window.pageXOffset);
      //divY = y - parseInt(document.all?document.documentElement.scrollTop:window.pageYOffset);
      //divWidth = parseInt(objDiv.width);
      //divHeight = parseInt(objDiv.height);
      //newX = x;
      //newY = y;
      //if (divX + divWidth > document.documentElement.clientWidth) {
        //newX = x + (document.documentElement.clientWidth - (divX + divWidth));
      //}
      //if (divY + divHeight > document.documentElement.clientHeight) {
        //newY = y + (document.documentElement.clientHeight - (divY + divHeight));
      //}
      //objDiv.style.left = newX+"px";
      //objDiv.style.top = newY+"px";
      //objDiv.style.zIndex = '100';
      //objDiv.style.display = 'block';
    //}

    return false;

  }

  function search_view_toggle_date() {

    objDiv = document.getElementById("date_panel");
    if (objDiv.style.display == "none") {
      g_search_panel_height += 125;
      objDiv.style.display = "block";
    } else {
      g_search_panel_height -= 125;
      objDiv.style.display = "none";
    }
    document.getElementById("search_panel_panel").style.height=g_search_panel_height+"px";
    document.getElementById("folder_panel_panel").style.bottom=g_search_panel_height+"px";

  }

  function search_view_toggle_size() {

    objDiv = document.getElementById("size_panel");
    if (objDiv.style.display == "none") {
      g_search_panel_height += 107;
      objDiv.style.display = "block";
    } else {
      g_search_panel_height -= 107;
      objDiv.style.display = "none";
    }
    document.getElementById("search_panel_panel").style.height=g_search_panel_height+"px";
    document.getElementById("folder_panel_panel").style.bottom=g_search_panel_height+"px";

  }
