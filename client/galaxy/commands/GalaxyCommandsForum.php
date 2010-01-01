<?php

class Topic extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPut;
	public $endpoint = 'topics';
	
	public function __construct($channel)
	{
		$this->endpoint .= '/'.$channel;
	}
	
}

class TopicList extends GalaxyCommand
{
	public $method = GalaxyCommand::kMethodGet;
	public $endpoint = 'topics';
}

?>