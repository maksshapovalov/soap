<?php

include_once('config.php');
include('libs/Soap.php');

$url1 = "https://www.w3schools.com/xml/tempconvert.asmx?WSDL";
 try
    {
		$soap = new Soap($url1);
		$client = $soap->newClient();
		var_dump($client->__getFunctions());
	}
    catch (Exception $e)
    {
        $message = $message . '<br />' . $e->getMessage();
    }




include_once('templates/index.php');

?>
