
  var g_orig = "";

  function user_administration_update_user () {

    var objDiv = document.getElementById("user_fields");
    var objSelect = document.getElementById("user_id");
    var nIndex = objSelect.selectedIndex;
    var user_name = objSelect.options[nIndex].value;

    objDiv.style.display = "none";
    if (xmlhttp) {
      var url="/user_administration/get_user.php?user_name="+user_name;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objDiv.innerHTML = xmlhttp.responseText;
          }
        }
      }
      xmlhttp.send(null);
    }
    objDiv.style.display = "block";

  }

  function user_administration_ldap_update_user () {

    var objDiv = document.getElementById("user_fields");
    var user_name = document.getElementById("user_name").value;

    objDiv.style.display = "none";
    if (xmlhttp) {
      var url="/user_administration/ldap_update.php?user_name="+user_name;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objDiv.innerHTML = xmlhttp.responseText;
          }
        }
      }
      xmlhttp.send(null);
    }
    objDiv.style.display = "block";

  }

  function user_administration_remove_user () {

    var user_name = document.getElementById("user_name").value;

    if (xmlhttp) {
      var url="/user_administration/remove_user.php?user_name="+user_name;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            document.location = "/user_administration/index.php";
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function user_administration_save_user () {

    var user_name = document.getElementById("user_name").value;
    var display_name = document.getElementById("display_name").value;
    var first_name = document.getElementById("first_name").value;
    var last_name = document.getElementById("last_name").value;
    var office = document.getElementById("office").value;
    var department = document.getElementById("department").value;
    var title = document.getElementById("title").value;
    var manager = document.getElementById("manager").value;
    var email_address = document.getElementById("email_address").value;
    var sms_number = document.getElementById("sms_number").value;
    var phone_number = document.getElementById("phone_number").value;
    var cell_phone_number = document.getElementById("cell_phone_number").value;
    var nIndex = document.getElementById("group").selectedIndex;
    var group_id = document.getElementById("group").options[nIndex].value;

    if (xmlhttp) {
      var url="/user_administration/save_user.php?user_name="+user_name+"&display_name="+display_name+"&first_name="+first_name+"&last_name="+last_name+"&office="+office+"&department="+department+"&title="+title+"&manager="+manager+"&email_address="+email_address+"&sms_number="+sms_number+"&phone_number="+phone_number+"&cell_phone_number="+cell_phone_number+"&group_id="+group_id;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            document.location = "/user_administration/index.php";
          } else {
            objDiv.innerHTML = "User save partially failed - "+xmlhttp.responseText;
          }
        }
      }
      xmlhttp.send(null);
    }

  }

  function user_administration_add_user () {

    var user_name = document.getElementById("user_name").value;
    var objDiv = document.getElementById("user_fields");

    if (xmlhttp) {
      var url="/user_administration/add_user.php?user_name="+user_name;
      xmlhttp.open("GET", url, true);
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
          if (xmlhttp.status == 200) {
            objDiv.innerHTML = xmlhttp.responseText;
          } else {
            objDiv.innerHTML = "User add partially failed";
          }
        }
      }
      xmlhttp.send(null);
    }

  }
