<?php
class Curl{
	private $post;
	private $function;
	
	public function setPost ($post)
	{
		if (!empty($post))
		{
			$this->post = $post;
		}
		else
		{
			throw new Exception ("Post is empty");
		}	
	}
	
	public function setFunction ($function)
	{
		if (!empty($function))
		{
			$this->function = $function;
		}
		else
		{
			throw new Exception ("Field is empty");
		}	
	}
	
	public function getResult()
	{
		$url = 'https://www.w3schools.com/xml/tempconvert.asmx/'.$this->function;
		$postResponse = $this->curlPost($url, $this->post);
		return $postResponse;
	}
	
	
	private function curlPost($page_url, $post) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $page_url); // Куда отправляем
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post); //Пост запрос
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.w3schools.com', 'Content-Type: application/x-www-form-urlencoded', 'Content-Length: '.strlen($post))); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Возвращаем, но не выводим на экран результат
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