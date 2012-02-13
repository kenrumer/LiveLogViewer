<?php

  //$client = new SoapClient("http://ddmcore01.prod.idc1.level3.com:8080/axis2/services/UcmdbService?wsdl", array('login' => "rumer.ken", 'password' => "G9lf4U&I"));

  //var_dump($client->__getFunctions());
  //var_dump($client->__getTypes());

  //$part1 = array ("test", "service", "");
  //$result = $client->getCIsByType($part1);

  $wsdl = "http://ddmcore02.prod.idc1.level3.com:8080/axis2/services/UcmdbService?wsdl";
  $username = "rumer.ken";
  $password = "G7lf4U&I";
  $client = new SoapClient($wsdl, array('trace' => 1, 'login' => $username, 'password' => $password));

  $part1 = array (
    'cmdbContext' => array(
      'callerApplication' => "script"
    ),
    'type' => "j2eeserver",
    'properties' => array( 
      //'propertiesList' => array(
        //'propertyName' => "j2ee_application_installed_path"
      //)
      'predefinedProperties' => array(
        'simplePredefinedProperties' => array(
          array('name' => "DERIVED"),
          array('name' => "CONCRETE"),
          array('name' => "NAMING")
        )
      )
    )
  );

  $response = $client->getCIsByType($part1);
  echo "Request :<br>", $client->__getLastRequest(), "<br>";
  print_r($response);
  foreach($response->CIs as $CI) {
    foreach ($CI as $j2eeserver) {
      echo("Name = ".$j2eeserver->props->strProps->strProp[1]->value."\n");
      echo("ID = ".$j2eeserver->ID->_."\n");
      $part1 = array (
        'cmdbContext' => array(
          'callerApplication' => "script"
        ),
        //'CIsTypedProperties' => array(
          //'typedProperties' => array(
            //'type' => "",
            //'properties' => array(
              //'predefinedTypedProperties' => array(
                //'simplePredefinedProperties' => array(
                  //'simplePredefinedProperty' => array(
                    //'name' => "DERIVED"
                  //)
                //)
              //)
            //)
          //)
        //),
        'IDs' => array(
          'ID' => $j2eeserver->ID->_
        )
      );

      $response2 = $client->getCIsById($part1);
      print_r ($response2);
    }
  }
  //echo "Request :<br>", $client->__getLastRequest(), "<br>";
  //echo "Response :<br>", $client->__getLastResponse(), "<br>";
  //echo "RESPONSE HEADERS:\n" . $client->__getLastResponseHeaders() . "<br>";
 
?>
