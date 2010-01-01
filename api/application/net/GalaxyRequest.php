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
			
			$context                     = $this->context_for_realm($authorization->realm);
			$context->origin             = $authorization->application;
			$context->origin_description = $authorization->description;
			
			if($context)
			{
				$api    = $this->commandLibraryForType($authorization->instance);
				
				// format: command_method e.g., channels_get, topics_post, topics_delete
				$method = GalaxyAPI::endpoint().'_'.strtolower($_SERVER['REQUEST_METHOD']);
				
				if(!$api){
					GalaxyResponse::unauthorized();
				}
				
				// accessing the application
				if(!$context->channel)
				{
					if($context->application == $authorization->application)
					{
						if(method_exists($api, $method))
						{
							$response = $api->$method($context);
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
					if(method_exists($api, $method))
					{
						$response = $api->$method($context);
					}
					
					echo $response;
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
	
	private function context_for_realm($realm)
	{
		$value = null;
		// realm should begin with glxy://
		
		if(strpos($realm, GalaxyAPIConstants::kSchemeGalaxy) !== false)
		{
			$realm = substr($realm, strlen(GalaxyAPIConstants::kSchemeGalaxy));
			$value = new GalaxyContext();
			
			$parts = explode('.', $realm);
			
			// com.galaxy.community                -- application (3 parts)
			// com.galaxy.community.channel        -- channel (4 parts)
			// com.galaxy.community.channel.123456 -- more (5+ parts)
			
			if(count($parts) > 4)
			{
				$value->application = implode('.', array_slice($parts, 0, 3));
				$value->channel     = implode('.', array_slice($parts, 0, 4));
				$value->more        = implode('.', array_slice($parts, 4));
			}
			else if(count($parts) == 4)
			{
				$value->application = implode('.', array_slice($parts, 0, 3));
				$value->channel     = $realm;
			}
			else
			{
				$value->application = $realm;
			}
		}
		
		return $value;
	}
	
	
}
?>