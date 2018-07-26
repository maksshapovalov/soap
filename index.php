<?php


$options = array(
                 'trace' => true,
                 'exceptions' => 0,
                 'login' => 'sampleUser',
                 'password' => 'abc123abc123abc123abc123abc123abc123',
                 );
$client = new SoapClient('http://flightxml.flightaware.com/soap/FlightXML2/wsdl', $options);

// get the weather.
$params = array("airport" => "KAUS");
$result = $client->Metar($params);

    echo '<pre>';
    print_r($result);
    echo '</pre>';

?>