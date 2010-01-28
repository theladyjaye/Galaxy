<?php
/**
 *    Galaxy - Core
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
 *    @package galaxy
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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