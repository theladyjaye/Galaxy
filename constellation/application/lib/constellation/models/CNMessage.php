<?php
class CNMessage
{
	private $title;
	private $body;
	private $context;
	
	public static function messageWithContext($context)
	{
		$message = new CNMessage();
		$message->context = $context;
		return $message;
	}
	
	public function setTitle($value)
	{
		$this->title = $value;
	}
	
	public function setBody($value)
	{
		$this->body = $value;
	}
	
	public function data()
	{
		return array('title' => $this->title,
		             'body'  => $this->body);
	}
	
	public function context()
	{
		return $this->context;
	}
	
	public function __get($key)
	{
		$value = null;
		if(isset($this->{$key}))
		{
			$value = $this->{$key};
		}
		
		return $value;
	}
}
?>