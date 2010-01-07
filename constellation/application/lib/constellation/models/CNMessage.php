<?php
class CNMessage
{
	private $title;
	private $body;
	private $author;
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
		return array('title'  => $this->title,
		             'body'   => $this->body,
		             'author' => $this->author->data());
	}
	
	public function setAuthor(CNAuthor $value)
	{
		$this->author = $value;
	}
	
	public function context()
	{
		return $this->context;
	}
}
?>