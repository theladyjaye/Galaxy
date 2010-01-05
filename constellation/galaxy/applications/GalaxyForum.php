<?php
class GalaxyForum extends GalaxyApplication
{
	protected function initialize(){}
	
	public function forum_list()
	{
		return $this->channels();
	}
	
	public function message_new(GalaxyForumMessage $message)
	{
		$command = new Message();
		$command->setContent($message->data());
		
		$options       = $this->defaultCommandOptions();
		$options['id'] = $message->context;
		
		$response = $this->execute($command, $options);
		return $response->result;
	}
	
	public function messages_list($topic, $page=0, $limit=Galaxy::kLimitDefault)
	{
		$command = new TopicMessages();
		
		$command->setContent(array('page'    => $page, 
		                           'limit'   => $limit));
		
		$options       = $this->defaultCommandOptions();
		$options['id'] = $topic;
		
		$response = $this->execute($command, $options);
		return $response->result;
	}
	
	public function topics_delete($topic_id)
	{
		// DELETE to topics endpoint
	}
	
	public function topics_new($channel, GalaxyForumTopic $topic)
	{
		$command = new Topic();
		$command->setContent($topic->data());
		
		$options       = $this->defaultCommandOptions();
		$options['id'] = $channel;
		
		$response = $this->execute($command, $options);
		return $response->result;
	}
	
	public function topics_list($channel, $page=0, $limit=Galaxy::kLimitDefault)
	{
		$command = new TopicList();
		$command->setContent(array('page'    => $page, 
		                           'limit'   => $limit));
		
		$options       = $this->defaultCommandOptions();
		$options['id'] = $channel;
		
		$response = $this->execute($command, $options);
		return $response->result;
	}
	
	public function __toString()
	{
		return Galaxy::kApplicationForum;
	}
}
?>