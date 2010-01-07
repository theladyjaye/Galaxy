<?php
require 'CNCommands.php';
class CNRequests
{
	public function topic_list(Constellation $constellation, $channel, $page, $limit)
	{
		$command = new CNTopicList();
		$command->setContent(array('page'    => $page, 
		                           'limit'   => $limit));

		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $channel;

		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function topic_new(Constellation $constellation, CNTopic $topic)
	{
		$command = new CNTopicNew();
		$command->setContent($topic->data());

		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $topic->context();

		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function topic_messages(Constellation $constellation, $topic, $page, $limit)
	{
		$command = new CNTopicMessages();
		
		$command->setContent(array('page'    => $page, 
		                           'limit'   => $limit));
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $topic;
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function message_new(Constellation $constellation, CNMessage $message)
	{
		$command = new CNMessageNew();
		$command->setContent($message->data());
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $message->context();
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
}
?>