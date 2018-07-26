<?php
class Soap {

private $urlWsdl;
private $client;

public function setUrl($url)
{
	if (!empty($url))
	{
		$this->urlWsdl = $url;
	}
	else
	{
		throw new Exception ("Url is empty");
	}	
}

public function getResult($func, $req)
{
	$this->startClient();
	return $this->client->$func($req);
}

private function startClient()
{
	$this->client = new SoapClient($this->urlWsdl);
}

	
	
}
?>