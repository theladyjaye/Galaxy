<?php
class PutStory implements RenegadeCommand
{
	private $content;
	private $document;
	private $authorization;
	
	public function __construct($content)
	{
		$this->content  = $content;
		$this->document = hash('md5', $this->content);
	}
	
	public function request()
	{
		$api_path       = RenegadeConnection::kApiLocation;
		$host           = RenegadeConnection::kHost;
		$content_length = strlen($this->content);
		
		return <<<REQUEST
PUT $api_path/story/$this->document HTTP/1.0
Authorization: $this->authorization
Content-Length: $content_length
Host: $host
Connection: Close
Content-Type: application/json

$this->content

REQUEST;
	}
	
	public function setAuthorization(RenegadeAuthorization $value)
	{
		$this->authorization = $value->__toString();
	}
	
	public function descriptor()
	{
		$array          = array();
		$array['verb']  = 'PUT';
		$array['uri']   = "http://".RenegadeConnection::kHost.RenegadeConnection::kApiLocation."/story/".$this->document;
		
		return $array;
	}
	
	public function __toString()
	{
		return 'RenegadeCommand::PutStory';
	}
}
?>

