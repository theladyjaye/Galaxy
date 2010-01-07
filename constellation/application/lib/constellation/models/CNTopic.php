<?php
class CNTopic
{
	private $title;
	private $body;
	private $context;
	
	public static function topicWithContext($context)
	{
		$topic = new CNTopic();
		$topic->context = $context;
		return $topic;
	}
	
	public static function topicWithTitleAndBody($title, $body)
	{
		$topic        = new CNTopic();
		$topic->title = $title;
		$topic->body  = $body;
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
	
	public function data()
	{
		return array('title' => $this->title,
		             'body'  => $this->body);
	}
}
?>