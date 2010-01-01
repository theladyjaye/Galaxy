<?php
abstract class GalaxyCommand
{
	const kMethodGet    = 'GET';
	const kMethodPost   = 'POST';
	const kMethodPut    = 'PUT';
	const kMethodDelete = 'DELETE';
	
	public $method;
	public $endpoint;
	public $content;
	public $content_type;
	public $scheme = 'http://';
	
	public function setContentType($value)
	{
		$this->content_type = $value;
	}
	
	public function setContent($value)
	{
		$this->content = $value;
	}
}

class Channels extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'channels';
}
?>