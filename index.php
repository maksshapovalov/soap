<?php

$wsdl = ('http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL');

$cbr = new SoapClient($wsdl,array('trace' => 1));
$date = $cbr->GetLatestDateTime();

echo 'Курс валют на '.date('d-m-Y',strtotime($date->GetLatestDateTimeResult)).'</br>';
$result = $cbr->GetCursOnDateXML(array('On_date'=>$date->GetLatestDateTimeResult));
echo '<pre>';
    var_dump($cbr->__getLastRequest());
    echo '</pre>';
    

if ($result->GetCursOnDateXMLResult->any) 
{
	$xml = new SimpleXMLElement($result->GetCursOnDateXMLResult->any);
	foreach ($xml->ValuteCursOnDate as $currency) 
	{
		if ('USD' == $currency->VchCode)
		{
			echo 'Доллар США $ = '.($currency->Vcurs).' &#8381;</br>';
		}
		if ('EUR' == $currency->VchCode)
		{
			echo 'Евро € = '.($currency->Vcurs).' &#8381;</br>';
		}
		//echo $currency->VchCode.' = '.($currency->Vcurs).'</br>';
	}
}

 

?>