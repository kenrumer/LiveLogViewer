<?php

  require_once ("/app/asc/core/docroot/common/include/database.inc");
  require_once ("/app/asc/core/docroot/common/include/backend_config.inc");

  $frontend_server = getenv('SERVER_NAME');
  $backend_config = new backend_config();
  $backend_config->read_config();
  $database = new database($backend_config);

?>

