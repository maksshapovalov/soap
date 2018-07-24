<?php
include ('lib/Curl.php');
$url = "https://www.w3schools.com/xml/tempconvert.asmx?WSDL";
$client = new SoapClient($url);

//var_dump($client->__getFunctions());

$celsius = '42';
$farenheitObj = $client->CelsiusToFahrenheit(['Celsius' => $celsius]);
$farenheit = $farenheitObj->CelsiusToFahrenheitResult;

echo "</br>Convert Celsius to Fahrenheit:</br>";
echo $celsius.'&deg;C = '.$farenheit.'&deg;F</br>';

$celsiusObj = $client->FahrenheitToCelsius(['Fahrenheit' => $farenheit]);
$celsius = $celsiusObj->FahrenheitToCelsiusResult;
echo "</br>Convert Fahrenheit to Celsius:</br>";
echo $farenheit.'&deg;F = '.$celsius.'&deg;C</br>';

try
{
	$curl = new Curl;
	$function = 'CelsiusToFahrenheit';
	$post = 'Celsius='.$celsius;

	$curl->setPost($post);
	$curl->setFunction($function);
	$farenheitHtml = $curl->getResult();
	
	echo "</br>CUrl Convert Celsius to Fahrenheit:</br>";
	echo $celsius.'&deg;C = '.$farenheitHtml.'&deg;F</br>';
	
	$function = 'FahrenheitToCelsius';
	$post = 'Fahrenheit='.$farenheit;

	$curl->setPost($post);
	$curl->setFunction($function);
	
	$celsius = $curl->getResult();
	echo "</br>Curl Convert Fahrenheit to Celsius:</br>";
	echo $farenheit.'&deg;F = '.$celsius.'&deg;C</br>';
}
catch(Exception $e)
{
  echo $e->getMessage();
}
?>