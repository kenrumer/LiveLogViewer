<?php

  include("./include/asc.inc");

  rename("/app/asc/core/docroot/deploy/deploy.zip", "/app/asc/core/docroot/deploy_archive/".date('hisY', strtotime("now")));
  
  system("zip -r /app/asc/core/docroot/deploy/deploy /app/asc/node/template 2>&1 1>/dev/null");
  system("zip -r /app/asc/core/docroot/deploy/deploy /app/asc/satellite/template 2>&1 1>/dev/null");
  system("zip -r /app/asc/core/docroot/deploy/deploy /app/asc/core/template 2>&1 1>/dev/null");
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTd XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTd/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>
      ASC - Deployment Results
    </title>
    <script language="javascript">
  function toggleDeployDirDisplay (strDiv) {

    objDiv = document.getElementById(strDiv);
    if (objDiv.style.display == "none") {
      objDiv.style.display = "block";
    } else {
      objDiv.style.display = "none";
    }

  }
    </script>
  </head>
  <body>
<?php
  $nodes = array("student1", "student2", "student3", "student4", "student5", "student6");
  foreach ($nodes as $node) {
    if (isset($_SERVER['HTTPS'])) {
      include ("https://".urlencode($common_backend_user).":".urlencode($common_backend_password)."@".$common_frontend_server."/".$node."/deployer.php");
    } else {
      include ("http://".urlencode($common_backend_user).":".urlencode($common_backend_password)."@".$common_frontend_server."/".$node."/deployer.php");
    }
  }
?>
  </body>
</html>
