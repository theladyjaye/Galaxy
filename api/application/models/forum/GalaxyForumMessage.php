<?php
class GalaxyForumMessage
{
	private $context;
	private $title;
	private $body;
	private $topic;
	private $author_name;
	private $author_avatar_url;
	
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
	
	public function setAuthorName($value)
	{
		$this->author_name = $value;
	}
	
	public function setAuthorAvatarUrl($value)
	{
		$this->author_avatar_url = $value;
	}
	
	public function data()
	{
		
		return array('_id'                => (string) new MongoID(),
			         'title'              => $this->title,
		             'body'               => $this->body,
		             'author_name'        => $this->author_name,
		             'author_avatar_url'  => $this->author_avatar_url,
		             'origin'             => $this->context->origin,
		             'origin_description' => $this->context->origin_description,
		             'origin_domain'      => $this->context->origin_domain,
		             'topic'              => $this->topic,
		             'created'            => GalaxyAPI::datetime(),
		             'type'               => GalaxyAPIConstants::kTypeForumMessage);
	}
}
?>