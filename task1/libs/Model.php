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
	
	public function getConvert($value, $function)
	{
		$this->value = $value;
		$this->function = $function;
		
		$this->setData('Title', 'Convert '.$this->value.' '.str_replace('To',' to ', $this->function));
		
		$this->getConvertCurl();
		$this->getConvertSoap();		
	}
	
	private function getConvertCurl()
	{
		$this->curl->setHost('www.w3schools.com');
		
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
		
		$curlResult = $this->curl->getResult($url, $post);
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
