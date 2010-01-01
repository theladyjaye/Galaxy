<?php
class GalaxyForum extends GalaxyApplication
{
	protected function initialize(){}
	
	public function forum_list()
	{
		return $this->channels();
	}
	
	public function posts_list($topic_id)
	{
		
	}
	
	public function topics_reply()
	{
		// POST to a topics endpoint
	}
	
	public function topics_new(GalaxyForumTopic $topic, $channel)
	{
		$command = new Topic($channel);
		$command->setContent(json_encode($topic->data()));
		$command->setContentType('application/json');
		$response = $this->execute($command);
		return $response->result;
	}
	
	public function topics_delete($topic_id)
	{
		// DELETE to topics endpoint
	}
	
	
	public function topics_list($id, $limit=25)
	{
		$command = new TopicList();
		$command->setData(array('channel' => $id));
		
		$response = $this->execute($command);
		return $response->result;
	}
	
	public function __toString()
	{
		return Galaxy::kApplicationForum;
	}
}
?>