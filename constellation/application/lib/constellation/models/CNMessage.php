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
		$author = $this->author->data();
		
		if(empty($author)){
			throw new Exception('Constellation message must be assigned an author');
		}
		
		return array('title'             => $this->title,
		             'body'              => $this->body,
		             'author_name'       => $author['name'],
		             'author_avatar_url' => $author['avatar_url']);
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