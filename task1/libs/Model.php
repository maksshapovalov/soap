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
		$url = 'http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx';
		$headers = array('Host: www.cbr.ru',
						'Connection: Keep-Alive',
						'User-Agent: PHP-SOAP/5.6.30',
						'Content-Type: text/xml; charset=utf-8',
						'SOAPAction: "http://web.cbr.ru/GetCursOnDateXML"',
						'Content-Length: '.strlen($request['request']));

		$curlResult = ($this->curl->getResult($url, $request['request'], $headers));
		$curlResult = new SimpleXMLElement(str_ireplace(['soap:', 'm:'], '', $curlResult));
		$this->setData('valuteCurl', $this->getValutesXML($curlResult->Body[0]->GetCursOnDateXMLResponse[0]->GetCursOnDateXMLResult[0]->ValuteData[0]));
		$this->setData('valuteSoap', $this->getValutesXML(new SimpleXMLElement($result->GetCursOnDateXMLResult->any)));
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
		$valutes = array();
		foreach ($result->ValuteCursOnDate as $currency) 
		{
			if ('USD' == $currency->VchCode)
			{
				$valutes[] = $currency->VchCode.' $ = '.($currency->Vcurs).' &#8381;';
			}
			if ('EUR' == $currency->VchCode)
			{
				$valutes[] = $currency->VchCode.' € = '.($currency->Vcurs).' &#8381;';
			}
		}
		return $valutes;
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
