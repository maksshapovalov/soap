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

public function getLastRequest()
{
	//return array('response' => $this->client->__getLastResponse(),
				//'request' => $this->client->__getLastRequest());
	return $this->client->__getLastRequest();
}

private function startClient()
{
	$this->client = new SoapClient($this->urlWsdl, array('trace' => 1));
}
	
}
?>