<?php
abstract class GalaxyCommand
{
	const kMethodGet    = 'GET';
	const kMethodPost   = 'POST';
	const kMethodPut    = 'PUT';
	const kMethodDelete = 'DELETE';
	
	
	public $method;
	public $action;
	public $scheme = 'http://';
}

class Channels extends GalaxyCommand
{
	public $method = GalaxyCommand::kMethodGet;
	public $action = 'channels';
}
?>