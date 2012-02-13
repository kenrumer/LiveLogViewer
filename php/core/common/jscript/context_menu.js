  var contextDisabled = false;
  var g_objContextMenu;
  var g_objNode;
  var x, y;

  if (document.addEventListener) {
    document.addEventListener("click", context_menu_mouse_click, false);
  } else if (document.attachEvent) {
    document.attachEvent("onclick", context_menu_mouse_click);
  } else {
    document.onclick = context_menu_mouse_click;
  }

  if (document.addEventListener) {
    document.addEventListener("mousemove", context_menu_trace_mouse, false);
  } else if (document.attachEvent) {
    document.attachEvent("onmousemove", context_menu_trace_mouse);
  } else {
    document.onmousemove = context_menu_trace_mouse;
  }

  function context_menu_mouse_click(e) {

    context_menu_close_context();
    return true;

  }

  function context_menu_trace_mouse(e) {

    if (document.all) {
      if (document.body) {
        x = document.body.scrollLeft + event.clientX;
        y = document.body.scrollTop + event.clientY;
      }
    } else {
      x = e.pageX;
      y = e.pageY;
    }

  }

  function context_menu_download_item() {

    context_menu_close_context();
    document.location.href = "/common/zip_item.php?server_id="+g_objNode.getAttribute("item_id")+"&path="+g_objNode.getAttribute("item_path");

  }

  function context_menu_explore_item() {

    close_context();
    document.location.href = "/file_explorer/index.php?ids="+g_objNode.getAttribute("item_id")+"&paths="+g_objNode.getAttribute("item_path");

  }

  function context_menu_item_click(funct) {

    context_menu_close_context();
    eval(funct+"(g_objNode)");

  }

  function context_menu_disable_context() {

    contextDisabled = true;
    context_menu_close_context();

  }

  function context_menu_close_context(){

    if (g_objContextMenu) { g_objContextMenu.style.display = 'none'; }
    if (top.g_objContextMenu) { top.g_objContextMenu.style.display = 'none'; }
    output_frame = window.output_frame;
    if (output_frame) {
      if (output_frame.g_objContextMenu) {
        output_frame.g_objContextMenu.style.display = 'none';
      }
    }

  }

  function context_menu_show_context_menu(objNode) {
    var newX, newY;

    context_menu_close_context();
    g_objNode = objNode;
    g_objContextMenu = document.getElementById(g_objNode.getAttribute("item_type")+"_context_menu");

    if (g_objContextMenu) {

      contextX = x - parseInt(document.all?document.documentElement.scrollLeft:window.pageXOffset);
      contextY = y - parseInt(document.all?document.documentElement.scrollTop:window.pageYOffset);
      contextWidth = parseInt(g_objContextMenu.width);
      contextHeight = parseInt(g_objContextMenu.height);

      newX = x;
      newY = y;

      if (contextX + contextWidth > document.documentElement.clientWidth) {
        newX = x + (document.documentElement.clientWidth - (contextX + contextWidth));
      }
      if (contextY + contextHeight > document.documentElement.clientHeight) {
        newY = y + (document.documentElement.clientHeight - (contextY + contextHeight));
      }

      g_objContextMenu.style.left = newX+"px";
      g_objContextMenu.style.top = newY+"px";
      g_objContextMenu.style.zIndex = '100';
      g_objContextMenu.style.display = 'block';
      return false;

    }

  }

