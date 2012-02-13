<?php

  include ("../include/database.inc");

  asc_database_connect();
  $applications = asc_database_get_all_applications();
  asc_database_close();

?>

<?php

  foreach($applications as $application) {
    echo ($application);
  }

?>
