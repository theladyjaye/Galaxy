<?php
require 'lib/galaxy/Galaxy.php';
require 'ConstellationDelegate.php';
require 'commands/CNRequests.php';
require 'models/CNMessage.php';
require 'models/CNAuthor.php';

class Constellation extends GalaxyApplication
{
	
	const kCommandForumList       = 0x10;
	const kCommandForumTopcis     = 0x11;
	const kCommandMessagesList    = 0x12;
	
	protected $application_id     = 'com.galaxy.community';
	protected $application_key    = '03105797f2eae24be6d1ac90500493c0';
	protected $application_secret = '34c6587fec895845450c4b82b13cae55';
	
	//protected $application_id     = 'com.galaxy.test';
	//protected $application_key    = 'bbf8b8970943467e372f579924a601ca';
	//protected $application_secret = '43fcadbcba58c40dbf913293c4939408';
	
	protected $application_format = Galaxy::kFormatJSON;
	
	private $galaxy;
	private $requests;
	
	public function __construct()
	{
		$this->requests = new CNRequests();
	}
	
	public function forum_list()
	{
		$response = null;
		
		if($this->delegate)
		{
			if($this->delegate->constellationShouldGetForums($this))
			{
				$response = $this->delegate->galaxyCachedResponseForCommand($this, Constellation::kCommandForumList);
				
				if(empty($response))
				{
					$response = $this->channels();
					$this->delegate->galaxySetCacheForResponse($this, Constellation::kCommandForumList, null, $response);
				}
			}
		}
		
		return $response;
	}
	
	public function topic_list($channel, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)
	{
		$response = null;
		
		if($this->delegate)
		{
			if($this->delegate->constellationShouldGetTopicsForForum($this, $channel))
			{
				$arguments = array('forum' => $channel,
				                   'page'  => $page,
				                   'limit' => $limit);
				
				$response = $this->delegate->galaxyCachedResponseForCommand($this, Constellation::kCommandForumTopcis, $arguments);
				
				if(empty($response))
				{
					$response = $this->requests->topic_list($this, $channel, $page, $limit);
					$this->delegate->galaxySetCacheForResponse($this, Constellation::kCommandForumTopcis, $arguments, $response);
				}
			}
		}
		
		return $response;
	}
	
	public function topic_new(CNMessage $message)
	{
		$response = null;
		
		if($this->delegate)
		{
			if($this->delegate->constellationShouldPostTopic($this, $message))
			{
				$response = $this->requests->topic_new($this, $message);
			}
		}
		
		return $response;
	}
	
	public function message_new(CNMessage $message)
	{
		$response = null;
		if($this->delegate)
		{
			if($this->delegate->constellationShouldPostMessage($this, $message))
			{
				$response = $this->requests->message_new($this, $message);
			}
		}
		
		return $response;
	}
	
	public function topic_messages($topic, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)
	{
		$response = null;

		if($this->delegate)
		{
			if($this->delegate->constellationShouldGetMessagesForTopic($this, $topic))
			{
				$arguments = array('topic' => $topic,
				                   'page'  => $page,
				                   'limit' => $limit);
				
				$response = $this->delegate->galaxyCachedResponseForCommand($this, Constellation::kCommandMessagesList, $arguments);
				
				if(empty($response))
				{
					$response = $this->requests->topic_messages($this, $topic, $page, $limit);
					$this->delegate->galaxySetCacheForResponse($this, Constellation::kCommandMessagesList, $arguments, $response);
				}
			}
		}
		
		return $response;
	}
}
?>