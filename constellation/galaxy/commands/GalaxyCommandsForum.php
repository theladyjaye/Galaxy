<?php

class Topic extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'topics';
}

class TopicList extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'topics';
}

class TopicMessages extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'messages';
}

class Message extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'messages';
}

?>