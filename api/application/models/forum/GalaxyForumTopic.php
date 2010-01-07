<?php
class GalaxyForumTopic
{
	private $context;
	private $title;
	private $author_name;
	private $author_avatar_url;
	
	public static function topicWithContext(GalaxyContext $context)
	{
		$topic          = new GalaxyForumTopic();
		$topic->context = $context;
		return $topic;
	}
	
	public function setTitle($value)
	{
		$this->title = $value;
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
			         'author_name'        => $this->author_name,
		             'author_avatar_url'  => $this->author_avatar_url,
		             'origin'             => $this->context->origin,
		             'origin_description' => $this->context->origin_description,
		             'created'            => time(),
		             'type'               => GalaxyAPIConstants::kTypeForumTopic);
	}
}
?>