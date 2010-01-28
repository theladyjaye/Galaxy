<?php
/**
 *    Galaxy - API
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
 *    @package api
 *    @subpackage net
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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
			echo GalaxyResponse::unauthorized();
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
			$context->origin_domain      = $authorization->domain;
			
			if($context)
			{
				$api    = $this->commandLibraryForType($authorization->instance);
				
				// format: command_method e.g., channels_get, topics_post, topics_delete
				$method = GalaxyAPI::methodForEndpoint(GalaxyAPI::endpoint());
				
				
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
						else
						{
							GalaxyResponse::unauthorized();
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
					$has_permission  = false;
					$db_certificates = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseRedis, GalaxyAPIConstants::kDatabaseCertificates);
					$permissions     = json_decode($db_certificates->get(GalaxyAPIConstants::kTypeCertificate.':'.$authorization->oauth_consumer_key.':'.$context->channel));
					
					$verb = strtolower($_SERVER['REQUEST_METHOD']);
					
					
					switch($verb)
					{
						case 'get':
							$has_permission = ($permissions & GalaxyAPIConstants::kPermissionRead) ? true : false;
							break;
						
						case 'post':
						case 'put':
							$has_permission = ($permissions & GalaxyAPIConstants::kPermissionWrite) ? true : false;
							break;
						
						case 'delete':
							$has_permission = ($permissions & GalaxyAPIConstants::kPermissionDelete) ? true : false;
							break;
					}
					
					
					if($has_permission && method_exists($api, $method))
					{
						$log = new GalaxyLog();
						$log->setEndpoint(GalaxyAPI::endpoint());
						$log->setContext($context);
						$log->setMethod($verb);
						$log->write();
						
						$response = $api->$method($context);
					}
					else
					{
						echo GalaxyResponse::unauthorized();
					}
					
					echo $response;
				}
				
			}
			else
			{
				echo  GalaxyResponse::unauthorized();
			}
		}
		else
		{
			echo "*****";
			echo GalaxyResponse::unauthorized();
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