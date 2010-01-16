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
 *    @subpackage commands
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
abstract class GalaxyApplication
{
	public function channels_get(GalaxyContext $context)
	{
		$options  = array('default' => GalaxyAPI::databaseForId($context->application));
		$channels = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, GalaxyAPIConstants::kDatabaseChannels, $options);
		$result   = $channels->find();
		$data     = array();
		
		foreach($result as $channel)
		{
			$data[] = array('id'                 => $channel['_id'],
			                'type'               => $channel['type'],
			                'label'              => $channel['label'],
			                'description'        => $channel['description'],
			                'origin'             => $channel['application'],
			                'origin_description' => $context->origin_description,
			                'origin_domain'      => $context->origin_domain,
			                'requests'           => $channel['requests']);
		}
		
		return GalaxyResponse::responseWithData($data);
	}
}
?>