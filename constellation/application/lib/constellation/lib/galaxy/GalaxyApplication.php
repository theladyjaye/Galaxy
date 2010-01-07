<?php
abstract class GalaxyApplication
{
	protected $application_id;
	protected $application_key;
	protected $application_secret;
	protected $application_format;
	
	protected $delegate;
	
	final public function setDelegate(GalaxyDelegate $value)
	{
		$this->delegate = $value;
	}
	
	final public function execute(GalaxyCommand $command, $options=null)
	{
		$options    = $options ? $options : $this->defaultCommandOptions();
		$connection = GalaxyConnection::initWithCommandAndOptions($command, $options);
		$response   = $connection->start();
		return $response;
	}
	
	final public function defaultCommandOptions()
	{
		// right now we are just using OAuth
		// at some point, we may consider OAuth WRAP
		// right now we just want to git-r-done and I don't
		// feel like reading a new specificaion and implementing it ;)
		return array('format'        => $this->application_format,
		             'id'            => $this->application_id,
		             'authorization' => array('type'   => Galaxy::kAuthorizationOAuth,
			                                  'key'    => $this->application_key,
		                                      'secret' => $this->application_secret));
	}
	
	final public function channels()
	{
		$response   = $this->execute(new Channels());
		return $response->result;
	}
}
?>