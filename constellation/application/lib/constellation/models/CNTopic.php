<?php
class CNTopic
{
	private $title;
	private $body;
	private $author;
	private $context;
	
	public static function topicWithContext($context)
	{
		$topic = new CNTopic();
		$topic->context = $context;
		return $topic;
	}
	
	public function setTitle($value)
	{
		$this->title = $value;
	}
	
	public function setBody($value)
	{
		$this->body = $value;
	}
	
	public function setAuthor($value)
	{
		$this->author = $value;
	}
	
	public function context()
	{
		return $this->context;
	}
	
	public function data()
	{
		return array('title'  => $this->title,
		             'body'   => $this->body,
		             'author' => $this->author);
	}
}
?>