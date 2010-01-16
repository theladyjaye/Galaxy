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
 *    @subpackage models
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyLog
{
	private $endpoint;
	private $context;
	private $method;
	
	public function setMethod($value)
	{
		$this->method = $value;
	}
	public function setEndpoint($value)
	{
		$this->endpoint = $value;
	}
	
	public function setContext(GalaxyContext $value)
	{
		$this->context = $value;
	}
	
	public function write()
	{
		$resource       = $this->context->channel;
		if(!empty($this->context->more))
		{
			$resource .= '.'.$this->context->more;
		}
		
		$history        = array('_id'                => (string) new MongoID(),
		                        'origin'             => $this->context->origin,
		                        'origin_description' => $this->context->origin_description,
		                        'origin_domain'      => $this->context->origin_domain,
		                        'endpoint'           => $this->endpoint,
		                        'method'             => $this->method,
		                        'resource'           => $resource,
		                        'timestamp'          => GalaxyAPI::datetime());
		
		$application_id = GalaxyAPI::applicationIdForChannelId($this->context->channel);
		$options        = array('default' => GalaxyAPI::databaseForId($application_id));
		$db             = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, null, $options);
		$logs           = $db->selectCollection(GalaxyAPIConstants::kDatabaseLog);
		
		// this might be a bottle neck
		// how much value is in the individual channel quests count?
		if(empty($this->context->more))
		{
			$inc_key    = array('_id'=>$this->context->channel);
			$inc_value  = array('$inc'=>array('requests'=>1));
			
			$master = $db->selectCollection(GalaxyAPIConstants::kDatabaseChannels);
			$master->update($inc_key, $inc_value);
			
			// update the request counter for the subscriber copy as well
			if(GalaxyAPI::applicationIdForChannelId($this->context->channel) != $this->context->origin)
			{
				$options_local = array('default' => GalaxyAPI::databaseForId($this->context->origin));
				$subscriber    = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, GalaxyAPIConstants::kDatabaseChannels, $options_local);
				$subscriber->update($inc_key, $inc_value);
			}
		}
		else
		{
			$requests = $db->selectCollection(GalaxyAPI::databaseforId($this->context->channel));
			$requests->update(array('_id'=>$this->context->more), array('$inc'=>array('requests'=>1)));
		}
		
		// this definitely is important
		$logs->insert($history);
		
	}
}
?>