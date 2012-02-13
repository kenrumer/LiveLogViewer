  var logged_in = false;

  function access_check_login() {

    if (xmlhttp) {
      var url = "/access/check_login.php";
      var params = "";
      xmlhttp.open("GET", url, false);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xmlhttp.setRequestHeader('Content-length', params.length);
      xmlhttp.setRequestHeader('Connection', 'close');
      xmlhttp.send(null);
      if (xmlhttp.status == 403) {
        objBody = document.getElementsByTagName("body")[0];
        objDiv = document.createElement("div");
        objDiv.setAttribute("id", "access_freeze_panel");
        objDiv.innerHTML = "<div class=\"access freeze panel\"></div><div class=\"access inner panel\"><div class=\"common blue_steel title\"><span class=\"common blue_steel title\">ASC user login</span></div><div class=\"common blue_steel content with_title left top\"><form onsubmit=\"javascript:access_login('ajax');return false;\"><div class=\"access user_name label\">User name:</div><div class=\"access user_name field\"><input style=\"width: 150px;\" name=\"user_name\" type=\"text\" id=\"user_name\"></div><div class=\"access password label\">Password:</div><div class=\"access password field\"><input style=\"width: 150px;\" name=\"password\" type=\"password\" id=\"password\"></div><div class=\"access login button\"><input type=\"submit\" value=\"login\" /></div></form><div class=\"access messages\" id=\"access_messages\"></div></div></div>";
        objBody.appendChild(objDiv);
        return false;
      }
      return true;
    }

    return false;

  }

  function access_login(type) {

    var objDiv = document.getElementById("access_messages");
    var strUserName = document.getElementById("user_name").value;
    var strPassword = document.getElementById("password").value;
    if (xmlhttp) {
      var url = "/access/login.php";
      var params = "user_name="+encodeURIComponent(strUserName)+"&password="+encodeURIComponent(strPassword);
      xmlhttp.open("POST", url, false);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xmlhttp.setRequestHeader('Content-length', params.length);
      xmlhttp.setRequestHeader('Connection', 'close');
      xmlhttp.send(params);
      if (xmlhttp.status == 403) {
        objDiv.innerHTML = xmlhttp.responseText;
      } else if (xmlhttp.status == 200) {
        objDiv.innerHTML = "";
        if (type == "ajax") {
          document.getElementsByTagName("body")[0].removeChild(document.getElementById("access_freeze_panel"));
        } else {
          document.location.reload(true);
        }
      }
    }

    return false;

  }

