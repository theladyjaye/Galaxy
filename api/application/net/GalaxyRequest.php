<?php
require 'GalaxyAuthorizationOAuth.php';
class GalaxyRequest
{
	public function __construct()
	{
		$this->headers = apache_request_headers();
		$this->process();
	}
	
	private function process()
	{
		if(isset($this->headers['Authorization']))
		{
			if(strpos($this->headers['Authorization'], 'OAuth') !== false)
			{
				$this->requestWithAuthorizationOAuth();
			}
		}
		else
		{
			GalaxyResponse::unauthorized();
		}
	}
	
	private function requestWithAuthorizationOAuth()
	{
		$authorization = new GalaxyAuthorizationOAuth($this->headers['Authorization']);
		
		if($authorization->isAuthorized())
		{
			// load the application command context:
			$api      = null;
			$response = null; // GalaxyResponse
			
			
			// At this point we know the user has a valid application
			// if they are attempting to access a channel, we need to confirm the channel 
			// permissions, if they are accessing the root of their application, they are good
			// to go at this point.
			$realm = $this->process_realm($authorization->realm);
			
			if($realm)
			{
				$api  = $this->commandLibraryForType($authorization->instance);

				if(!$api){
					GalaxyResponse::unauthorized();
				}
				
				// accessing the application
				if(!$realm['channel'])
				{
					if($realm['application'] == $authorization->application)
					{
						/*
							TODO Perform the requested action, we need a more robust way to handle the request URI 
							especially in the case of /command/option/option... etc.
						*/
						
						$method = substr($_SERVER['REQUEST_URI'], 1);
						if(method_exists($api, $method))
						{
							$response = $api->$method($realm['application']);
						}
						
						echo $response;
					}
					else
					{
						GalaxyResponse::unauthorized();
					}
				}
				// accessing a channel within the application
				else
				{
					// check the authorization permissions for a channel action. 
					// GET             = read
					// POST/PUT/DELETE = write
					
					$response = null;
				}
				
			}
			else
			{
				GalaxyResponse::unauthorized();
			}
		}
		else
		{
			GalaxyResponse::unauthorized();
		}
	}
	
	private function commandLibraryForType($value)
	{
		$api = null;
		switch($value)
		{
			case GalaxyAPIConstants::kTypeForum:
				require $_SERVER['DOCUMENT_ROOT'].'/application/commands/GalaxyForum.php';
				$api = new GalaxyForum();
				break;
		}
		
		return $api;
	}
	
	private function process_realm($realm)
	{
		$value = null;
		// realm should begin with glxy://
		if(strpos($realm, GalaxyAPIConstants::kSchemeGalaxy) !== false)
		{
			$realm = substr($realm, strlen(GalaxyAPIConstants::kSchemeGalaxy));
			$value = array('application'=>null, 'channel'=>null);
			$parts = explode('.', $realm);
			
			// com.galaxy.community.announcements -- channel (4 parts)
			// com.galaxy.community               -- application (3 parts)
			if(count($realm) == 4)
			{
				$parts                = array_pop($parts);
				$value['channel']     = $realm;
				$value['application'] = implode('.', $parts);
			}
			else
			{
				$value['application'] = $realm;
			}
		}
		
		return $value;
	}
	
	
}
?>