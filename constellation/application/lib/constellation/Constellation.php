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
	protected $application_key    = '3be355bc06dc4923a3e894e5675e3f0a';
	protected $application_secret = '91da6fc8ae68944913ac4f2f549886b2';
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
				$response = $this->delegate->galaxyCachedResponseForCommand($this, Constellation::kCommandForumTopcis, func_get_args());
				
				if(empty($response))
				{
					$response = $this->requests->topic_list($this, $channel, $page, $limit);
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
			if($this->delegate->constellationShouldPostTopicToForum($this, $message, $channel))
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
				$response = $this->delegate->galaxyCachedResponseForCommand($this, Constellation::kCommandMessagesList, func_get_args());
				
				if(empty($response))
				{
					$response = $this->requests->topic_messages($this, $topic, $page, $limit);
				}
			}
		}
		
		return $response;
	}
}
?>