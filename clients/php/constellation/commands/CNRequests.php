<?php
/**
 *    Galaxy - Constellation
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package constellation
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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
	
	public function topic_new(Constellation $constellation, CNMessage $topic)
	{
		$command = new CNTopicNew();
		$command->setContent(json_encode($topic->data()));
		$command->setContentType('application/json');
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $topic->context();

		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function topic_delete(Constellation $constellation, $topic_id)
	{
		$command = new CNTopicDelete();
		//$command->setContent(array("id"=>$topic_id));
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $topic_id;//$topic->context();

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
		$command->setContent(json_encode($message->data()));
		$command->setContentType('application/json');
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $message->context();
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function message(Constellation $constellation, $id)
	{
		$command       = new CNMessageDetails();
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $id;
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function message_update(Constellation $constellation, CNMessage $message)
	{
		$command       = new CNMessageUpdate();
		$command->setContent($message->data());
		
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $message->context();
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
	
	public function message_delete(Constellation $constellation, CNMessage $message)
	{
		$command       = new CNMessageDelete();
		$options       = $constellation->defaultCommandOptions();
		$options['id'] = $message->context();
		
		$response = $constellation->execute($command, $options);
		return $response->result;
	}
}
?>