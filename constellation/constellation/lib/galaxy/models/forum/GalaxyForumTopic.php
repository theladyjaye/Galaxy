<?php
class GalaxyForumTopic
{
	private $title;
	private $body;
	
	public static function topicWithTitleAndBody($title, $body)
	{
		$topic        = new GalaxyForumTopic();
		$topic->title = $title;
		$topic->body  = $body;
		return $topic;
	}
	
	public function data()
	{
		return array('title' => $this->title,
		             'body'  => $this->body);
	}
}
?>