  var minus = new Image();
  minus.src = "/common/images/minusimg.png";

  var plus = new Image();
  plus.src = "/common/images/plusimg.png";

  function search_results_show_grep (file, server_id, search_text, div) {

    objDiv = eval("document.getElementById(\""+div+"\")");
    if (objDiv.expanded == undefined) {
      objDiv.expanded = "false";
    }
    if (objDiv.expanded == "false") {
      if (access_check_login()) {
        objDiv.style.visibility = 'hidden';
        objDiv.expanded = "true";
        if (xmlhttp) {
          var url = "show_grep.php?server_id="+server_id+"&search_text="+escape(search_text)+"&file="+escape(file);
          xmlhttp.open("GET", url, true);
          xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
          xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              objDiv.innerHTML = xmlhttp.responseText.replace(/\n/g, "<br />");
              eval("document.getElementById(\""+div+"expand\").src=minus.src");
              objDiv.style.visibility='visible';
            }
          }
          xmlhttp.send(null);
        }
      }
    } else {
      objDiv.innerHTML = "";
      eval("document.getElementById(\""+div+"expand\").src=plus.src");
      objDiv.expanded = "false";
    }
  }
