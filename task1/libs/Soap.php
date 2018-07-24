<?php
class Soap
{
	public $client;
	private $wsdlUrl;
	
	public function __construct($getWsdlUrl = null) {
		if (!empty($getWsdlUrl)) {
			$this->wsdlUrl = $getWsdlUrl;
		} else {
			throw new Exception ("A URL to WEBService not defined.");
		}
	}
	
	public function newClient() {
		$this->client = new SoapClient($this->wsdlUrl);
		return $this->client;
	}
	
	
	
	

}
?>
