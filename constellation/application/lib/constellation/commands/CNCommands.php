<?php
class CNTopicMessages extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'messages';
}

class CNTopicNew extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'topics';
}

class CNTopicList extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'topics';
}

class CNMessageNew extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'messages';
}
?>