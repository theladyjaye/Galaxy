<?php
class GalaxyForumTopic
{
	private $context;
	private $title;
	
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
	
	public function data()
	{
		return array('_id'                => (string) new MongoID(),
			         'title'              => $this->title,
		             'origin'             => $this->context->origin,
		             'origin_description' => $this->context->origin_description,
		             'created'            => time(),
		             'type'               => GalaxyAPIConstants::kTypeForumTopic);
	}
}
?>