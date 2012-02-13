
  var minus = new Image();
  minus.src = "/explorer/images/minusimg.bmp";
  var plus = new Image();
  plus.src = "/explorer/images/plusimg.bmp";

  var lastClicked = "summary";

  function viewsFrameViewClick (objView) {

    var strID1 = objView.id.substring(0, objView.id.length - 5);
    if (lastClicked) {
      var strID2 = lastClicked;
      eval("document.getElementById(\""+strID2+"href2\").className=\"notselected\"");
    }
    eval("document.getElementById(\""+strID1+"href2\").className=\"selected\"");
    lastClicked = strID1;

    top.document.getElementById('outputFrame').contentWindow.location = "/im/"+strID1+"_frame.php";

  }
