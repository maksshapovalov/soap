<?php
class Curl{
	
	public function getResult($url, $post, $headers)
	{
		
		$postResponse = $this->curlPost($url, $post, $headers);
		
		return $postResponse;
	}
	
	
	private function curlPost($page_url, $post, $headers) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $page_url); // ���� ����������
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); //���� ������
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
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