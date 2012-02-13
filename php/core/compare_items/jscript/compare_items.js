  var last_checked1 = null, last_checked2 = null;
  var last_checked1_type, last_checked2_type;
  var last_checked1_server, last_checked2_server;
  var last_checked1_path, last_checked2_path;

  var bemail = false;
  var bsave_as = false;
  var bword_wrap = false;
  var binfo = true;
  var bfind = false;
  var old_content = "";
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

  function compare_items_add_item(objNode) {

    if (top.output_frame) {
      top.output_frame.document.location.href = "/compare_items/index.php?type="+objNode.getAttribute("item_type")+"&server_id="+objNode.getAttribute("item_id")+"&path="+objNode.getAttribute("item_path");
    }

  }

  function compare_items_remove_item(pos) {

    if (access_check_login()) {
      var objRow = document.getElementById("row"+pos);
      if (objRow) {
        objRow.style.display = "none";
      }
      if (xmlhttp) {
        var url = "/compare_items/remove.php?row="+pos;
        xmlhttp.open("GET", url, true);
        xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
        xmlhttp.send(null);
      }
    }

  }

  function compare_items_remove_all() {

    if (access_check_login()) {
      var i = 0;
      var objRow = document.getElementById("row"+i);
      while (objRow) {
        objRow.style.display = "none";
        i++;
        objRow = document.getElementById("row"+i);
      }
      if (xmlhttp) {
        var url = "/compare_items/remove.php?row=all";
        xmlhttp.open("GET", url, true);
        xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
        xmlhttp.send(null);
      }
    }

  }

  function compare_items_toggle_item(objCheckbox, type, server, path) {

    var objMessageDiv = document.getElementById("compare_items_message_area");

    if (objCheckbox.checked) {

      if (last_checked2) {
        //This is the third check, clear the oldest
        last_checked2.checked = false;
        last_checked2 = null;
        last_checked2_type = "";
        last_checked2_server = "";
        last_checked2_path = "";
      }

      //Make sure the types match
      if (last_checked1) {
        //This is the second check, move the previous check to last_check2
        if (last_checked1_type != type) {
          compare_items_clear_selections();
          objMessageDiv.style.display = "block";
        } else {
          last_checked2 = last_checked1;
          last_checked2.checked = last_checked1.checked;
          last_checked2_type = last_checked1_type;
          last_checked2_server = last_checked1_server;
          last_checked2_path = last_checked1_path;
          objMessageDiv.style.display = "none";
        }
      } else {
        objMessageDiv.style.display = "none";
      }

      //Put current check to last_check1
      last_checked1 = null;
      last_checked1 = objCheckbox;
      last_checked1.checked = true;
      last_checked1_type = type;
      last_checked1_server = server;
      last_checked1_path = path;

    } else {
      objMessageDiv.style.display = "none";
      if (objCheckbox == last_checked1) {
        //Unchecked recent check, remove recent, move old check to recent, remove old
        last_checked1.checked = false;
        last_checked1 = null;

        if (last_checked2) {
          last_checked1 = last_checked2;
          last_checked1.checked = last_checked2.checked;
          last_checked1_type = last_checked2_type;
          last_checked1_server = last_checked2_server;
          last_checked1_path = last_checked2_path;

          last_checked2 = null;
          last_checked2_type = "";
          last_checked2_server = "";
          last_checked2_path = "";
        }
      }

      if (objCheckbox == last_checked2) {
        //Unchecked old check, just remove old
        last_checked2.checked = false;
        last_checked2 = null;
        last_checked2_type = "";
        last_checked2_server = "";
        last_checked2_path = "";
      }
    }

  }

  function compare_items_clear_selections() {

    if (last_checked2) {
      last_checked2.checked = false;
      last_checked2 = null;
      last_checked2_type = "";
      last_checked2_server = "";
      last_checked2_path = "";
    }
    if (last_checked1) {
      last_checked1.checked = false;
      last_checked1 = null;
      last_checked1_type = "";
      last_checked1_server = "";
      last_checked1_path = "";
    }

  }

  function compare_items_compare_items() {

    document.location.href = "/compare_items/show_results.php?type="+last_checked1_type+"&server1="+last_checked1_server+"&server2="+last_checked2_server+"&path1="+last_checked1_path+"&path2="+last_checked2_path;

  }

  function compare_items_grep() {

    if (old_content == "") {
      var objContent = document.getElementById('content');
      if (objContent) {
        old_content = objContent.innerHTML.substr(5, objContent.innerHTML.length -11);
      }
    }
    grep_text = document.getElementById('searchFor').value.toLowerCase();
    var lines = old_content.split("\n");
    var new_content = "<pre>\n";
    for (i = 0; i < lines.length; i++) {
      if (lines[i].toLowerCase().indexOf(grep_text) != -1) {
        new_content = new_content + lines[i] + "\n";
      }
    }
    new_content = new_content + "</pre>\n";
    document.getElementById('content').innerHTML = new_content;

  }

  function compare_items_refresh () {

    document.location.reload( true );

  }

  function compare_items_send_email () {

    if (access_check_login()) {
      var objDiv = document.getElementById('bottom');
      if (xmlhttp) {
        var url = "/compare_items/send_email.php";
        var strTo = document.getElementById('to').value;
        var strSubject = document.getElementById('subject').value;
        var strFileData = "";
        switch (document.getElementById('doc_version').value) {
          case 'original':
            if (old_content == "") {
              var objContent = document.getElementById('content');
              if (objContent) {
                old_content = objContent.innerHTML.substr(5, objContent.innerHTML.length -11);
              }
            }
            strFileData = old_content;
            break;
          case 'crispy':
            strFileData = document.getElementById('content').innerHTML;
            break;
        }
        strFileData = strFileData.substr(5, strFileData.length - 11);
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

  }

  function compare_items_save_as () {

    var strFileData = "";
    switch (document.getElementById('doc_version').value) {
      case 'original':
        if (old_content == "") {
          var objContent = document.getElementById('content');
          if (objContent) {
            old_content = objContent.innerHTML.substr(5, objContent.innerHTML.length -11);
          }
        }
        strFileData = old_content;
        break;
      case 'crispy':
        strFileData = document.getElementById('content').innerHTML;
        break;
    }
    document.getElementById('filedata').value = strFileData.substr(5, strFileData.length - 11);
    objForm = document.getElementById('save_as_form');
    objForm.submit();
    objButton_save_as = document.getElementById('save_as_button');
    bemail = false;
    objDiv = document.getElementById('bottom');
    objDiv.innerHTML = "";
    objButton_email.src = email.src;

  }

  function compare_items_toggle_save_as () {

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
      objDiv.innerHTML = '<form action=\"/compare_items/save_as.php\" method=\"POST\" onsubmit=\"compare_items_save_as();return false;\" id=\"save_as_form\">&nbsp;<select id=\"doc_version\"><option value=\"original\">Original</option><option value=\"crispy\">Current Format</option></select>&nbsp;filename: <input type=\"text\" name=\"filename\" id=\"filename\" value=\"'+strFileName+'\" /> <input type=\"hidden\" name=\"filedata\" id=\"filedata\"> <input type=\"submit\" value=\"Save\" /></form>';
      objButton_save_as.src = save_as_down.src;
      objButton_email.src = email.src;
      objButton_info.src = info.src;
      objButton_find.src = find.src;
    }

  }

  function compare_items_toggle_email () {

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
      objDiv.innerHTML = '<form onsubmit=\"compare_items_send_email();return false;\" />&nbsp;<select id=\"doc_version\"><option value=\"original\">Original</option><option value=\"crispy\">Current Format</option></select>&nbsp;to: <input type=\"text\" id=\"to\" /> subject: <input type=\"text\" id=\"subject\" /> <input type=\"submit\" value=\"Send\" /></form>';
      objButton_email.src = email_down.src;
      objButton_save_as.src = save_as.src;
      objButton_info.src = info.src;
      objButton_find.src = find.src;
    }

  }

  function compare_items_toggle_wrap () {

    objDiv = document.getElementById('content');
    objButton = document.getElementById('word_wrap_button');
    if (bword_wrap) {
      bword_wrap = false;
      objDiv.className = objDiv.className.replace(' HardBreak', '');
      objButton.src = word_wrap.src;
    } else {
      bword_wrap = true;
      objDiv.className = objDiv.className+' HardBreak';
      objButton.src = word_wrap_down.src;
    }

  }

  function compare_items_toggle_info () {

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

  function compare_items_toggle_find () {

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
      objDiv.innerHTML = '<form onSubmit=\"javascript:compare_items_grep();return false;\">&nbsp;text: <input type=\"text\" name=\"searchFor\" id=\"searchFor\" /> <input type=\"submit\" value=\"Search\" /></form>';
      objButton_find.src = find_down.src;
      objButton_save_as.src = save_as.src;
      objButton_email.src = email.src;
      objButton_info.src = info.src;
    }

  }
