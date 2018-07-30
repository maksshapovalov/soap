<?php 
include ('Curl.php');
include ('Soap.php');
class Model
{
	private $data;
	private $curl;
	private $soap;
	
	private $value, $function, $suf;
	
	public function __construct()
	{
		$this->curl = new Curl();
		$this->soap = new Soap();
	}
	
	public function setData($key, $val)
	{
		$this->data[$key] = $val;
		return true;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function getValute()
	{
		$this->soap->setUrl('http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL');
		$date = $this->soap->getResult('GetLatestDateTime', null);
		$result =  $this->soap->getResult('GetCursOnDateXML',(array('On_date'=>$date->GetLatestDateTimeResult)));
		$request = $this->soap->getLastRequest();
		echo '<pre>';
		var_dump($request);
		echo '</pre>';
		$url = 'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx';
		$headers = array('Host: www.cbr.ru',
						'Connection: Keep-Alive',
						'User-Agent: PHP-SOAP/5.6.30',
						'Content-Type: text/xml; charset=utf-8',
						'SOAPAction: "http://web.cbr.ru/GetCursOnDateXML"',
						'Content-Length: '.strlen($request['request']));

		$curlResult = ($this->curl->getResult($url, $request['request'], $headers));
		
		$curlResult = simplexml_load_string(str_ireplace(['soap:', 'm:'], '', $curlResult));
		echo '<pre>';
		var_dump($curlResult);
		echo '</pre>';
		$this->getValutesXML($curlResult->ValuteCursOnDate);
	}
	
	public function getConvert($value, $function)
	{
		$this->value = $value;
		$this->function = $function;
		
		$this->setData('Title', 'Convert '.$this->value.' '.str_replace('To',' to ', $this->function));
		
		$this->getConvertCurl();
		$this->getConvertSoap();		
	}
	
	private function getValutesXML ($result)
	{
		echo '<pre>';
		var_dump($result);
		echo '</pre>';
		$xml = new SimpleXMLElement($result);
		//var_dump($xml->GetCursOnDateXMLResult->any);
			foreach ($xml->ValuteCursOnDate as $currency) 
			{
				if ('USD' == $currency->VchCode)
				{
					echo $currency->Vname.' $ = '.($currency->Vcurs).' &#8381;</br>';
				}
				if ('EUR' == $currency->VchCode)
				{
					echo $currency->Vname.' € = '.($currency->Vcurs).' &#8381;</br>';
				}
				//echo $currency->VchCode.' = '.($currency->Vcurs).'</br>';
			}
	}
	
	private function getConvertCurl()
	{
		$url = 'https://www.w3schools.com/xml/tempconvert.asmx/'.$this->function;
		
		if ('FahrenheitToCelsius' == $this->function)
		{
			$post = 'Fahrenheit='.$this->value;
			$this->suf = '&deg;C';
		}
		else
		{
			$post = 'Celsius='.$this->value;
			$this->suf = '&deg;F';
		}
		
		$headers = array('Host: www.w3schools.com', 
						'Content-Type: application/x-www-form-urlencoded', 
						'Content-Length: '.strlen($post));
		$curlResult = $this->curl->getResult($url, $post, $headers);
		preg_match('#<string xmlns="https://www.w3schools.com/xml/">(.+?)</string>#is', $curlResult, $curlResult);
		
		$this->setData('Curl', $curlResult[1].$this->suf);
		return true;
	}
	
	private function getConvertSoap()
	{
		$this->soap->setUrl("https://www.w3schools.com/xml/tempconvert.asmx?WSDL");
		
		if ('FahrenheitToCelsius' == $this->function)
		{
			$req['Fahrenheit'] = $this->value;
		}
		else
		{
			$req['Celsius'] = $this->value;
		}
		$result = $this->soap->getResult($this->function, $req);
		$func = $this->function.'Result';
		
		$this->setData('Soap', $result->$func.$this->suf);
		return true;
	}
}
