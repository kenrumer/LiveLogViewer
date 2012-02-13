  var bemail = false;
  var bsave_as = false;
  var bword_wrap = false;
  var binfo = true;
  var bfind = false;
  var g_old_content = "";
  var grep_text = "";
  var timeoutId = 0;

  var email = new Image();
  var email_down = new Image();
  var save_as = new Image();
  var save_as_down = new Image();
  var info = new Image();
  var info_down = new Image();
  var find = new Image();
  var find_down = new Image();
  var word_wrap = new Image();
  var word_wrap_down = new Image();
  var tail = new Image();
  var tail_down = new Image();

  email.src = "/common/images/email.png";
  email_down.src = "/common/images/email_down.png";
  save_as.src = "/common/images/save_as.png";
  save_as_down.src = "/common/images/save_as_down.png";
  info.src = "/common/images/info.png";
  info_down.src = "/common/images/info_down.png";
  find.src = "/common/images/find.png";
  find_down.src = "/common/images/find_down.png";
  word_wrap.src = "/common/images/word_wrap.png";
  word_wrap_down.src = "/common/images/word_wrap_down.png";
  tail.src = "/common/images/tail.png";
  tail_down.src = "/common/images/tail_down.png";

  function grep() {

    grep_text = document.getElementById('searchFor').value.toLowerCase();
    var lines = g_old_content.split("\n");
    var new_content = "<pre>\n";
    for (i = 0; i < lines.length; i++) {
      if (lines[i].toLowerCase().indexOf(grep_text) != -1) {
        new_content = new_content + lines[i] + "\n";
      }
    }
    new_content = new_content + "</pre>\n";
    objContent = document.getElementById('content');
    if (objContent) {
      objContent.innerHTML = new_content;
    }

  }

  function file_viewer_tail_init () {

    objContent = document.getElementById('content');
    if (objContent) {
      g_old_content = objContent.innerHTML;
      var start = g_old_content.indexOf("<PRE>") + 5;
      if (g_old_content.indexOf("<PRE>") == -1) {
        start = g_old_content.indexOf("<pre>") + 5;
      }
      var lastPos = g_old_content.lastIndexOf("</PRE>");
      if (g_old_content.indexOf("</PRE>") == -1) {
        lastPos = g_old_content.lastIndexOf("</pre>");
        var length = lastPos - start;
        length = length - 1;
      } else {
        var length = lastPos - start;
        length = length - 2;
      }
      g_old_content = g_old_content.substr(start, length);
    }
    if (btail) {
      setTimeout("file_viewer_scroll_to_bottom()", 100);
      timeoutId = setTimeout("file_viewer_tail()", 1000);
    }

  }

  if (window.addEventListener) window.addEventListener("load", file_viewer_tail_init, false);
  else if (window.attachEvent) window.attachEvent("onload", file_viewer_tail_init);
  else window.onload = file_viewer_tail_init;

  function file_viewer_tail () {

    if (xmlhttp) {
      var params = "server_id="+nServer_id+"&path="+escape(strPath)+"&file_pos="+file_pos;
      var url="tail_file.php?server_id="+nServer_id+"&path="+escape(strPath)+"&file_pos="+file_pos;
      xmlhttp.open("GET", url, false);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.setRequestHeader("Content-length", params.length);
      xmlhttp.setRequestHeader("Connection", "close");
      xmlhttp.send(params);
      if (xmlhttp) {
        if (xmlhttp.status == 200) {
          response=xmlhttp.responseXML.documentElement;
          if (response) {
            if (response.getElementsByTagName("file_pos")[0]) {
              file_pos = response.getElementsByTagName("file_pos")[0].firstChild.data;
              if (response.getElementsByTagName("file_text")[0].firstChild) {
                g_old_content = g_old_content+response.getElementsByTagName("file_text")[0].firstChild.data;
                objContent = document.getElementById('content');
                if (objContent) {
                  objContent.innerHTML="<pre>"+g_old_content+"</pre>";
                }
              }
              timeoutId = setTimeout("file_viewer_scroll_to_bottom()",100);
            }
          }
        }
        if (btail) {
          timeoutId = setTimeout("file_viewer_tail()", 1000);
        }
      }
    }

  }

  function file_viewer_scroll_to_bottom() {

    objContent = document.getElementById('content');
    if (objContent) {
      objContent.scrollTop = objContent.scrollHeight;
    }

  }

  function file_viewer_refresh () {

    document.location.reload( true );

  }

  function file_viewer_toggle_tail () {

    objButton = document.getElementById('tail_button');
    if (btail) {
      btail = false;
      clearTimeout(timeoutId);
      if (objButton) {
        objButton.src = tail_down.src;
      }
    } else {
      btail = true;
      file_viewer_tail();
      if (objButton) {
        objButton.src = tail.src;
      }
    }

  }

  function file_viewer_send_email () {

    var strTo = document.getElementById('to').value;
    var strSubject = document.getElementById('subject').value;
    var strDocVersion = document.getElementById('doc_version').value;
    var objDiv = document.getElementById('bottom');
    objDiv.innerHTML = "";
    objButton_email = document.getElementById('email_button');
    bemail = false;
    objButton_email.src = email.src;
    if (xmlhttp) {
      var url = "/common/send_email.php";
      var strFileData = "";
      switch (strDocVersion) {
        case 'original':
          strFileData = g_old_content;
          break;
        case 'crispy':
          objContent = document.getElementById('content');
          if (objContent) {
            strFileData = objContent.innerHTML;
            strFileData = strFileData.substr(5, strFileData.length - 11);
          } else {
            strFileData = g_old_content;
          }
          break;
      }
      var params = "to="+encodeURIComponent(strTo)+"&subject="+encodeURIComponent(strSubject)+"&filename="+encodeURIComponent(strFileName)+"&filedata="+encodeURIComponent(strFileData);
      xmlhttp.open("POST", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length", params.length);
      xmlhttp.setRequestHeader("Connection", "close");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          objDiv.innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.send(params);
    }

  }

  function file_viewer_save_as () {

    var strSaveFileName = document.getElementById('filename').value;
    if (strSaveFileName == "") {
      strSaveFileName = strFileName;
    }
    alert(strSaveFileName);
    var strDocVersion = document.getElementById('doc_version').value;
    var objDiv = document.getElementById('bottom');
    objDiv.innerHTML = "";
    objButton_save_as = document.getElementById('save_as_button');
    bsave_as = false;
    objButton_save_as.src = save_as.src;
    if (xmlhttp) {
      var url = "/common/save_as.php";
      var strFileData = "";
      switch (strDocVersion) {
        case 'original':
          strFileData = g_old_content;
          break;
        case 'crispy':
          objContent = document.getElementById('content');
          if (objContent) {
            strFileData = objContent.innerHTML;
            strFileData = strFileData.substr(5, strFileData.length - 11);
          } else {
            strFileData = g_old_content;
          }
          break;
      }
      var params = "filename="+encodeURIComponent(strSaveFileName)+"&filedata="+encodeURIComponent(strFileData);
      xmlhttp.open("POST", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.setRequestHeader("Content-length", params.length);
      xmlhttp.setRequestHeader("Connection", "close");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          objDiv.innerHTML = "File saved";
        }
      }
      xmlhttp.send(params);
    }

  }

  function file_viewer_toggle_save_as () {

    objDiv = document.getElementById('bottom');
    objButton_save_as = document.getElementById('save_as_button');
    objButton_email = document.getElementById('email_button');
    objButton_info = document.getElementById('info_button');
    objButton_find = document.getElementById('find_button');
    if (bsave_as) {
      bsave_as = false;
      objDiv.innerHTML = "";
      objButton_save_as.src = save_as.src;
    } else {
      bsave_as = true;
      bemail = false;
      binfo = false;
      bfind = false;
      objDiv.innerHTML = '<form action=\"/common/save_as.php\" method=\"POST\" onsubmit=\"file_viewer_save_as();return false;\" id=\"save_as_form\">&nbsp;<select id=\"doc_version\"><option value=\"original\">Original</option><option value=\"crispy\">Current Format</option></select>&nbsp;filename: <input type=\"text\" name=\"filename\" id=\"filename\" value=\"'+strFileName+'\" /> <input type=\"hidden\" name=\"filedata\" id=\"filedata\"> <input type=\"submit\" value=\"Save\" /></form>';
      objButton_save_as.src = save_as_down.src;
      objButton_email.src = email.src;
      objButton_info.src = info.src;
      objButton_find.src = find.src;
    }

  }

  function file_viewer_toggle_email () {

    objDiv = document.getElementById('bottom');
    objButton_save_as = document.getElementById('save_as_button');
    objButton_email = document.getElementById('email_button');
    objButton_info = document.getElementById('info_button');
    objButton_find = document.getElementById('find_button');
    if (bemail) {
      bemail = false;
      objDiv.innerHTML = "";
      objButton_email.src = email.src;
    } else {
      bemail = true;
      bsave_as = false;
      binfo = false;
      bfind = false;
      objDiv.innerHTML = '<form onsubmit=\"file_viewer_send_email();return false;\" />&nbsp;<select id=\"doc_version\"><option value=\"original\">Original</option><option value=\"crispy\">Current Format</option></select>&nbsp;to: <input type=\"text\" id=\"to\" /> subject: <input type=\"text\" id=\"subject\" /> <input type=\"submit\" value=\"Send\" /></form>';
      objButton_email.src = email_down.src;
      objButton_save_as.src = save_as.src;
      objButton_info.src = info.src;
      objButton_find.src = find.src;
    }

  }

  function file_viewer_toggle_wrap () {

    objDiv = document.getElementById('content');
    objButton = document.getElementById('word_wrap_button');
    if (bword_wrap) {
      bword_wrap = false;
      if (objDiv) {
        objDiv.className = objDiv.className.replace(/ HardBreak/g, '');
      }
      if (objButton) {
        objButton.src = word_wrap.src;
      }
    } else {
      bword_wrap = true;
      if (objDiv) {
        objDiv.className = objDiv.className+' HardBreak';
      }
      if (objButton) {
        objButton.src = word_wrap_down.src;
      }
    }

  }

  function file_viewer_toggle_info () {

    objDiv = document.getElementById('bottom');
    objButton_save_as = document.getElementById('save_as_button');
    objButton_email = document.getElementById('email_button');
    objButton_info = document.getElementById('info_button');
    objButton_find = document.getElementById('find_button');
    if (binfo) {
      binfo = false;
      objDiv.innerHTML = "";
      objButton_info.src = info.src;
    } else {
      binfo = true;
      bsave_as = false;
      bemail = false;
      bfind = false;
      objDiv.innerHTML = "&nbsp;"+file_info;
      objButton_info.src = info_down.src;
      objButton_save_as.src = save_as.src;
      objButton_email.src = email.src;
      objButton_find.src = find.src;
    }

  }

  function file_viewer_toggle_find () {

    objDiv = document.getElementById('bottom');
    objButton_save_as = document.getElementById('save_as_button');
    objButton_email = document.getElementById('email_button');
    objButton_info = document.getElementById('info_button');
    objButton_find = document.getElementById('find_button');
    if (bfind) {
      bfind = false;
      objDiv.innerHTML = "";
      objButton_find.src = find.src;
    } else {
      bfind = true;
      bsave_as = false;
      bemail = false;
      binfo = false;
      objDiv.innerHTML = '<form onSubmit=\"javascript:grep();return false;\">&nbsp;text: <input type=\"text\" name=\"searchFor\" id=\"searchFor\" /> <input type=\"submit\" value=\"Search\" /></form>';
      objButton_find.src = find_down.src;
      objButton_save_as.src = save_as.src;
      objButton_email.src = email.src;
      objButton_info.src = info.src;
    }

  }
