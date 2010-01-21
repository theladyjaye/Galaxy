<?php
/**
 *    Galaxy - API
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
 *    @package api_models
 *    @subpackage forum
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyForumTopic
{
	private $context;
	private $title;
	private $author;
	private $origin_message_id;
	private $last_message;
	private $replies  = 0;
	private $requests = 0;
	

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
 
	public function setAuthor($value)
	{
		$valid = array('name'       => true,
		               'avatar_url' => true);
		
		$this->author = array_intersect_key($value, $valid);
	}
	
	public function setOriginMessageId($value)
	{
		$this->origin_message_id = $value;
	}
	
	public function setReplies($value)
	{
		$this->replies = $value;
	}
	
	public function setRequests($value)
	{
		$this->requests = $value;
	}
	
	public function setLastMessage(GalaxyForumMessage $message)
	{
		$this->last_message = $message;
	}
 
	public function data()
	{
		
		$last_message = $this->last_message ? $this->last_message->data() : null;
		
		return array('_id'                          => (string) new MongoID(),
		             'replies'                      => $this->replies,
		             'requests'                     => $this->requests,
			         'title'                        => $this->title,
			         'author'                       => $this->author,
			         'origin_message_id'            => $this->origin_message_id,
		             'source'                       => $this->context->source(),
		             'last_message'                 => $last_message,
		             'created'                      => GalaxyAPI::datetime(),
		             'type'                         => GalaxyAPIConstants::kTypeForumTopic);
	}
}
?>