<?php
class Curl{
	private $host;
	
	public function setHost ($host)
	{
		if (!empty($host))
		{
			$this->host = $host;
		}
		else
		{
			throw new Exception ("Host is empty");
		}	
	}
	
	public function getResult($url, $post)
	{
		$postResponse = $this->curlPost($url, $post);
		return $postResponse;
	}
	
	
	private function curlPost($page_url, $post) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $page_url); // ���� ����������
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); //���� ������
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: '.$this->host, 'Content-Type: application/x-www-form-urlencoded', 'Content-Length: '.strlen($post))); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ����������, �� �� ������� �� ����� ���������
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		if($info['http_code'] != 200 && $info['http_code'] != 404) {
			throw new Exception ($info['http_code']);
		}
		curl_close($ch);
		return $response;
	}
}
?>