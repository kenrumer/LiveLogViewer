  var g_edit = -1;

  function update_calendar(month, year) {
    var objSpan = document.getElementById("calendar_id");

    if (xmlhttp) {
      var url = "update_month.php?month="+month+"&year="+year;
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          objSpan.innerHTML = xmlhttp.responseText;
          objSpan.style.visibility='visible';
        }
      }
      xmlhttp.send(null);
    }
  }

  function update_date(day, month, year, day_of_week) {

    objTextbox = document.getElementById("recurrence_start_date");
    objTextbox.value = month+"/"+day+"/"+year+" ("+day_of_week+")";

  }

  function add_all_admin_members() {
    var objSelect1 = document.getElementById("available_admin_member");
    var objSelect2 = document.getElementById("selected_admin_member");
    var count = objSelect1.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect2.options.length;
      objSelect2.options[j] = new Option(objSelect1.options[i].text, objSelect1.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect1.options[0] = null;
    }
  }

  function add_selected_admin_member() {
    var objSelect1 = document.getElementById("available_admin_member");
    var objSelect2 = document.getElementById("selected_admin_member");
    var index = objSelect1.selectedIndex;
    if (index != -1) {
      var count = objSelect2.options.length;
      objSelect2.options[count] = new Option(objSelect1.options[index].text, objSelect1.options[index].value);
      objSelect1.options[index] = null;
    }
  }

  function remove_selected_admin_member() {
    var objSelect1 = document.getElementById("available_admin_member");
    var objSelect2 = document.getElementById("selected_admin_member");
    var index = objSelect2.selectedIndex;
    if (index != -1) {
      var count = objSelect1.options.length;
      objSelect1.options[count] = new Option(objSelect2.options[index].text, objSelect2.options[index].value);
      objSelect2.options[index] = null;
    }
  }

  function remove_all_admin_members() {
    var objSelect1 = document.getElementById("available_admin_member");
    var objSelect2 = document.getElementById("selected_admin_member");
    var count = objSelect2.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect1.options.length;
      objSelect1.options[j] = new Option(objSelect2.options[i].text, objSelect2.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect2.options[0] = null;
    }
  }

  function add_all_members() {
    var objSelect1 = document.getElementById("available_member");
    var objSelect2 = document.getElementById("selected_member");
    var count = objSelect1.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect2.options.length;
      objSelect2.options[j] = new Option(objSelect1.options[i].text, objSelect1.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect1.options[0] = null;
    }
  }

  function add_selected_member() {
    var objSelect1 = document.getElementById("available_member");
    var objSelect2 = document.getElementById("selected_member");
    var index = objSelect1.selectedIndex;
    if (index != -1) {
      var count = objSelect2.options.length;
      objSelect2.options[count] = new Option(objSelect1.options[index].text, objSelect1.options[index].value);
      objSelect1.options[index] = null;
    }
  }

  function remove_selected_member() {
    var objSelect1 = document.getElementById("available_member");
    var objSelect2 = document.getElementById("selected_member");
    var index = objSelect2.selectedIndex;
    if (index != -1) {
      var count = objSelect1.options.length;
      objSelect1.options[count] = new Option(objSelect2.options[index].text, objSelect2.options[index].value);
      objSelect2.options[index] = null;
    }
  }

  function remove_all_members() {
    var objSelect1 = document.getElementById("available_member");
    var objSelect2 = document.getElementById("selected_member");
    var count = objSelect2.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect1.options.length;
      objSelect1.options[j] = new Option(objSelect2.options[i].text, objSelect2.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect2.options[0] = null;
    }
  }

  function add_all_info_members() {
    var objSelect1 = document.getElementById("available_info_member");
    var objSelect2 = document.getElementById("selected_info_member");
    var count = objSelect1.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect2.options.length;
      objSelect2.options[j] = new Option(objSelect1.options[i].text, objSelect1.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect1.options[0] = null;
    }
  }

  function add_selected_info_member() {
    var objSelect1 = document.getElementById("available_info_member");
    var objSelect2 = document.getElementById("selected_info_member");
    var index = objSelect1.selectedIndex;
    if (index != -1) {
      var count = objSelect2.options.length;
      objSelect2.options[count] = new Option(objSelect1.options[index].text, objSelect1.options[index].value);
      objSelect1.options[index] = null;
    }
  }

  function remove_selected_info_member() {
    var objSelect1 = document.getElementById("available_info_member");
    var objSelect2 = document.getElementById("selected_info_member");
    var index = objSelect2.selectedIndex;
    if (index != -1) {
      var count = objSelect1.options.length;
      objSelect1.options[count] = new Option(objSelect2.options[index].text, objSelect2.options[index].value);
      objSelect2.options[index] = null;
    }
  }

  function remove_all_info_members() {
    var objSelect1 = document.getElementById("available_info_member");
    var objSelect2 = document.getElementById("selected_info_member");
    var count = objSelect2.options.length;
    for (i = 0; i < count; i++) {
      j = objSelect1.options.length;
      objSelect1.options[j] = new Option(objSelect2.options[i].text, objSelect2.options[i].value);
    }
    for (i = 0; i < count; i++) {
      objSelect2.options[0] = null;
    }
  }

  function add_rule() {
    g_edit = -1;
    var objDiv = document.getElementById("schedule_div");
    objDiv.style.display = 'block';
  }

  function edit_rule() {
    var objDiv = document.getElementById("schedule_div");
    var objSelect = document.getElementById("rule_list");
    g_edit = objSelect.selectedIndex;
    if (g_edit != -1) {
      var strText = objSelect.options[g_edit].text.split(" | ");
      objDiv.style.display = 'block';
      if (strText[0] == "Daily") {
        document.getElementById("recurrence_daily").checked = true;
      } else {
        document.getElementById("recurrence_daily").checked = false;
      }
      if (strText[0] == "Weekly") {
        document.getElementById("recurrence_weekly").checked = true;
      } else {
        document.getElementById("recurrence_weekly").checked = false;
      }
      if (strText[0] == "Monthly") {
        document.getElementById("recurrence_monthly").checked = true;
      } else {
        document.getElementById("recurrence_monthly").checked = false;
      }
      var objTime_select = document.getElementById("recurrence_time");
      for (i = 0; i < objTime_select.options.length; i++) {
        if (objTime_select.options[i].text == strText[1]) {
          objTime_select.selectedIndex = i;
          break;
        }
      }
      var objDate_textbox = document.getElementById("recurrence_start_date");
      objDate_textbox.value = strText[2];
    }
  }

  function delete_rule() {
    var objSelect = document.getElementById("rule_list");
    var index = objSelect.selectedIndex;
    if (index != -1) {
      objSelect.options[index] = null;
      if (index == g_edit) {
        cancel_recurrence();
      }
      if (index < g_edit) {
        g_edit--;
      }
    }
  }

  function cancel_recurrence() {
    
    var objDiv = document.getElementById("schedule_div");
    objDiv.style.display = 'none';
    g_edit = -1;

  }

  function save_recurrence() {

    var bFailed = false;
    var objSelect = document.getElementById("rule_list");
    var objDate_textbox = document.getElementById("recurrence_start_date");
    var objTime_select = document.getElementById("recurrence_time");
    var strText = "";
    if (document.getElementById("recurrence_daily").checked) {
      strText = "Daily | ";
    }
    if (document.getElementById("recurrence_weekly").checked) {
      strText = "Weekly | ";
    }
    if (document.getElementById("recurrence_monthly").checked) {
      strText = "Monthly | ";
    }
    var objDiv = document.getElementById("schedule_div");

    var count = objSelect.options.length;
    for (i = 0; i < count; i++) {
      if ((objSelect.options[i].text == strText+objTime_select.options[objTime_select.selectedIndex].text+" | "+objDate_textbox.value) && (g_edit != i)) {
        bFailed = true;
        alert("validation failed: entry already exists");
        break;
      }
    }
    if (!bFailed) {
      if (g_edit == -1) {
        var count = objSelect.options.length;
        objSelect.options[count] = new Option(strText+objTime_select.options[objTime_select.selectedIndex].text+" | "+objDate_textbox.value);
        g_edit = -1;
        objDiv.style.display = 'none';
      } else {
        objSelect.options[g_edit].text = strText+objTime_select.options[objTime_select.selectedIndex].text+" | "+objDate_textbox.value;
        g_edit = -1;
        objDiv.style.display = 'none';
      }
    }

  }

  function validate_recurrence () {

    var bFailed = false;
    var objSelect = document.getElementById("rule_list");
    var objDate_textbox = document.getElementById("recurrence_start_date");
    var objTime_select = document.getElementById("recurrence_time");
    var strText = "";
    if (document.getElementById("recurrence_daily").checked) {
      strText = "Daily | ";
    }
    if (document.getElementById("recurrence_weekly").checked) {
      strText = "Weekly | ";
    }
    if (document.getElementById("recurrence_monthly").checked) {
      strText = "Monthly | ";
    }
    var objDiv = document.getElementById("schedule_div");
    var count = objSelect.options.length;
    for (i = 0; i < count; i++) {
      if (objSelect.options[i].text == strText+objTime_select.options[objTime_select.selectedIndex].text+" | "+objDate_textbox.value) {
        bFailed = true;
        alert("validation failed: entry already exists");
        break;
      }
    }
    if (!bFailed) {
      alert("validation successful");
    }

  }

  function change_group(objSelect) {
    var objSpan = document.getElementById("calendar_id");

    if (xmlhttp) {
      var url = "get_group.php?group_id="+objSelect.value;
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          response = xmlhttp.responseXML.documentElement;
          users_count = response.getElementsByTagName("users_count")[0].childNodes[0].nodeValue;
          var users = new Array();
          for (i = 0; i < users_count; i++) {
            users[i] = new Array(3);
            users[i][0] = response.getElementsByTagName("users")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            users[i][1] = response.getElementsByTagName("users")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            users[i][2] = response.getElementsByTagName("users")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
          }
          users_for_group_count = response.getElementsByTagName("users_for_group_count")[0].childNodes[0].nodeValue;
          var users_for_group = new Array();
          for (i = 0; i < users_for_group_count; i++) {
            users_for_group[i] = new Array(4);
            users_for_group[i][0] = response.getElementsByTagName("users_for_group")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            users_for_group[i][1] = response.getElementsByTagName("users_for_group")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            users_for_group[i][2] = response.getElementsByTagName("users_for_group")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
          }
          pager_users_count = response.getElementsByTagName("pager_users_count")[0].childNodes[0].nodeValue;
          var pager_users = new Array();
          for (i = 0; i < pager_users_count; i++) {
            pager_users[i] = new Array(3);
            pager_users[i][0] = response.getElementsByTagName("pager_users")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            pager_users[i][1] = response.getElementsByTagName("pager_users")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            pager_users[i][2] = response.getElementsByTagName("pager_users")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
          }
          current_position = response.getElementsByTagName("current_position")[0].childNodes[0].nodeValue;
          var current_user_for_group = new Array(3);
          current_user_for_group[0] = response.getElementsByTagName("current_user_for_group")[0].childNodes[0].childNodes[0].childNodes[0].nodeValue;
          current_user_for_group[1] = response.getElementsByTagName("current_user_for_group")[0].childNodes[0].childNodes[1].childNodes[0].nodeValue;
          current_user_for_group[2] = response.getElementsByTagName("current_user_for_group")[0].childNodes[0].childNodes[2].childNodes[0].nodeValue;
          pager_users_for_group_count = response.getElementsByTagName("pager_users_for_group_count")[0].childNodes[0].nodeValue;
          var pager_users_for_group = new Array();
          for (i = 0; i < pager_users_for_group_count; i++) {
            pager_users_for_group[i] = new Array(4);
            pager_users_for_group[i][0] = response.getElementsByTagName("pager_users_for_group")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            pager_users_for_group[i][1] = response.getElementsByTagName("pager_users_for_group")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            pager_users_for_group[i][2] = response.getElementsByTagName("pager_users_for_group")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
            pager_users_for_group[i][3] = response.getElementsByTagName("pager_users_for_group")[0].childNodes[i].childNodes[3].childNodes[0].nodeValue;
          }
          email_users_count = response.getElementsByTagName("email_users_count")[0].childNodes[0].nodeValue;
          var email_users = new Array();
          for (i = 0; i < email_users_count; i++) {
            email_users[i] = new Array(3);
            email_users[i][0] = response.getElementsByTagName("email_users")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            email_users[i][1] = response.getElementsByTagName("email_users")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            email_users[i][2] = response.getElementsByTagName("email_users")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
          }
          email_users_for_group_count = response.getElementsByTagName("email_users_for_group_count")[0].childNodes[0].nodeValue;
          var email_users_for_group = new Array();
          for (i = 0; i < email_users_for_group_count; i++) {
            email_users_for_group[i] = new Array(3);
            email_users_for_group[i][0] = response.getElementsByTagName("email_users_for_group")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            email_users_for_group[i][1] = response.getElementsByTagName("email_users_for_group")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            email_users_for_group[i][2] = response.getElementsByTagName("email_users_for_group")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
          }
          schedule_count = response.getElementsByTagName("schedule_count")[0].childNodes[0].nodeValue;
          var schedules = new Array();
          for (i = 0; i < schedule_count; i++) {
            schedules[i] = new Array(4);
            schedules[i][0] = response.getElementsByTagName("schedules")[0].childNodes[i].childNodes[0].childNodes[0].nodeValue;
            schedules[i][1] = response.getElementsByTagName("schedules")[0].childNodes[i].childNodes[1].childNodes[0].nodeValue;
            schedules[i][2] = response.getElementsByTagName("schedules")[0].childNodes[i].childNodes[2].childNodes[0].nodeValue;
            schedules[i][3] = response.getElementsByTagName("schedules")[0].childNodes[i].childNodes[3].childNodes[0].nodeValue;
          }
          count = document.getElementById("available_admin_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("available_admin_member").options[0] = null;
          }
          count = document.getElementById("selected_admin_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("selected_admin_member").options[0] = null;
          }
          count = document.getElementById("available_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("available_member").options[0] = null;
          }
          count = document.getElementById("selected_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("selected_member").options[0] = null;
          }
          count = document.getElementById("available_info_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("available_info_member").options[0] = null;
          }
          count = document.getElementById("selected_info_member").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("selected_info_member").options[0] = null;
          }
          count = document.getElementById("rule_list").options.length;
          for (i = 0; i < count; i++) {
            document.getElementById("rule_list").options[0] = null;
          }
          document.getElementById("current_member").value = current_user_for_group[1]+" "+current_user_for_group[2]; 
          l = 0;
          for (i = 0; i < users_count; i++) {
            bFound = false;
            for (j = 0; j < users_for_group_count; j++) {
              if (users[i][0] == users_for_group[j][0]) {
                bFound = true;
              }
            }
            if (!bFound) {
              document.getElementById("available_admin_member").options[l] = new Option(users[i][1]+" "+users[i][2], users[i][0]);
              l++;
            }
          }
          for (i = 0; i < users_for_group_count; i++) {
            document.getElementById("selected_admin_member").options[i] = new Option(users_for_group[i][1]+" "+users_for_group[i][2], users_for_group[i][0]);
          }
          l = 0;
          for (i = 0; i < pager_users_count; i++) {
            bFound = false;
            for (j = 0; j < pager_users_for_group_count; j++) {
              if (pager_users[i][0] == pager_users_for_group[j][0]) {
                bFound = true;
              }
            }
            if (!bFound) {
              document.getElementById("available_member").options[l] = new Option(pager_users[i][1]+" "+pager_users[i][2], pager_users[i][0]);
              l++;
            }
          }
          for (i = 0; i < pager_users_for_group_count; i++) {
            document.getElementById("selected_member").options[i] = new Option(pager_users_for_group[i][1]+" "+pager_users_for_group[i][2], pager_users_for_group[i][0]);
          }
          l = 0;
          for (i = 0; i < email_users_count; i++) {
            bFound = false;
            for (j = 0; j < email_users_for_group_count; j++) {
              if (email_users[i][0] == email_users_for_group[j][0]) {
                bFound = true;
              }
            }
            if (!bFound) {
              document.getElementById("available_info_member").options[l] = new Option(email_users[i][1]+" "+email_users[i][2], email_users[i][0]);
              l++;
            }
          }
          for (i = 0; i < email_users_for_group_count; i++) {
            document.getElementById("selected_info_member").options[i] = new Option(email_users_for_group[i][1]+" "+email_users_for_group[i][2], email_users_for_group[i][0]);
          }
          for (i = 0; i < schedule_count; i++) {
            document.getElementById("rule_list").options[i] = new Option(schedules[i][1]+" | "+schedules[i][2]+" | "+schedules[i][3], schedules[i][0]);
          }
        }
      }
      xmlhttp.send(null);
    }
  }

  function save_admin_members() {
    var objSelect = document.getElementById("rules_group");
    var objUsers = document.getElementById("selected_admin_member");

    if (xmlhttp) {
      var url = "save_admin_members.php?group_id="+objSelect.value;
      var count = objUsers.options.length;
      for (i = 0; i < count; i++) {
        url = url+"&users["+i+"]="+objUsers.options[i].value;
      }
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          window.status = xmlhttp.responseText;
        }
      }
      xmlhttp.send(null);
    }
  }

  function save_members() {
    var objSelect = document.getElementById("rules_group");
    var objUsers = document.getElementById("selected_member");

    if (xmlhttp) {
      var url = "save_members.php?group_id="+objSelect.value;
      var count = objUsers.options.length;
      for (i = 0; i < count; i++) {
        url = url+"&users["+i+"]="+objUsers.options[i].value;
      }
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          window.status = xmlhttp.responseText;
        }
      }
      xmlhttp.send(null);
    }
  }

  function save_info_members() {
    var objSelect = document.getElementById("rules_group");
    var objUsers = document.getElementById("selected_info_member");

    if (xmlhttp) {
      var url = "save_info_members.php?group_id="+objSelect.value;
      var count = objUsers.options.length;
      for (i = 0; i < count; i++) {
        url = url+"&users["+i+"]="+objUsers.options[i].value;
      }
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          window.status = xmlhttp.responseText;
        }
      }
      xmlhttp.send(null);
    }
  }

  function save_rule() {
    var objSelect = document.getElementById("rules_group");
    var objRules = document.getElementById("rule_list");

    if (xmlhttp) {
      var url = "save_rules.php?group_id="+objSelect.value;
      var count = objRules.options.length;
      for (i = 0; i < count; i++) {
        url = url+"&rules["+i+"]="+objRules.options[i].text;
      }
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          window.status = xmlhttp.responseText;
        }
      }
      xmlhttp.send(null);
    }
  }

  function save_one_time() {
    var objGroup = document.getElementById("one_time_group");
    var objMember = document.getElementById("one_time_member");
    var objMemberTextbox = document.getElementById("current_member");

    if (xmlhttp) {
      var url = "save_one_time.php?group_id="+objGroup.value+"&member_id="+objMember.value;
      xmlhttp.open("GET", url, true);
      xmlhttp.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");
      xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          window.status = xmlhttp.responseText;
          i = objMember.selectedIndex;
          objMemberTextbox.value = objMember.options[i].text;
        }
      }
      xmlhttp.send(null);
    }
  }
