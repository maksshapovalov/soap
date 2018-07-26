<?php 
include ('Curl.php');
class Model
{
	private $data;
	private $curl;
	
	private $value, $function;
	
	public function __construct()
	{
		$this->curl = new Curl();
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
		
		$this->getConvertCurl();
		
	}
	
	private function getConvertCurl()
	{
		$this->curl->setHost('www.w3schools.com');
		
		$url = 'https://www.w3schools.com/xml/tempconvert.asmx/'.$this->function;
		
		if ('FahrenheitToCelsius' == $this->function)
		{
			$post = 'Fahrenheit='.$this->value;
		}
		else
		{
			$post = 'Celsius='.$this->value;
		}
		$this->setData('Curl', $this->curl->getResult($url, $post));
		return true;
	}
	
}
