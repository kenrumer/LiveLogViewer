

  function file_management_toggle_add_entry() {

    var objDiv = document.getElementById("add_entry");
    var objCheckbox = document.getElementById("remove_entry_checkbox");
    if (objDiv.style.display == 'none') {
      objDiv.style.display = 'block';
      objCheckbox.checked = 0;
    } else {
      objDiv.style.display = 'none';
      objCheckbox.checked = 1;
    }
    return true;

  }

  function file_management_toggle_rotate_size() {

    var objDiv = document.getElementById("rotate_size");
    var objCheckbox = document.getElementById("rotate_on_size");
    if (objCheckbox.checked == 0) {
      objDiv.style.display = 'none';
    } else {
      objDiv.style.display = 'block';
    }
    return true;

  }

  function file_management_toggle_rotate_period() {

    var objDiv = document.getElementById("rotate_period");
    var objCheckbox = document.getElementById("rotate_on_period");
    if (objCheckbox.checked == 0) {
      objDiv.style.display = 'none';
    } else {
      objDiv.style.display = 'block';
    }
    return true;

  }

  function file_management_toggle_expire_size() {

    var objDiv = document.getElementById("expire_size");
    var objCheckbox = document.getElementById("expire_on_size");
    if (objCheckbox.checked == 0) {
      objDiv.style.display = 'none';
    } else {
      objDiv.style.display = 'block';
    }
    return true;

  }

  function file_management_toggle_expire_count() {

    var objDiv = document.getElementById("expire_count");
    var objCheckbox = document.getElementById("expire_on_count");
    if (objCheckbox.checked == 0) {
      objDiv.style.display = 'none';
    } else {
      objDiv.style.display = 'block';
    }
    return true;

  }




