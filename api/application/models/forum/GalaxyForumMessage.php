<?php
class GalaxyForumMessage
{
	private $context;
	private $title;
	private $body;
	private $topic;
	
	public static function messageWithContext(GalaxyContext $context)
	{
		$topic          = new GalaxyForumMessage();
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
	
	public function setTopic($value)
	{
		$this->topic = $value;
	}
	
	public function data()
	{
		return array('_id'                => (string) new MongoID(),
			         'title'              => $this->title,
		             'body'               => $this->body,
		             'origin'             => $this->context->origin,
		             'origin_description' => $this->context->origin_description,
		             'topic'              => $this->topic,
		             'created'            => time(),
		             'type'               => GalaxyAPIConstants::kTypeForumMessage);
	}
}
?>