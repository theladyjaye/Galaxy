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
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyAPI
{
	public static function endpoint()
	{
		
		$endpoint     = strtolower($_SERVER['REQUEST_URI']); // will start with a leading /
		$endpoint     = substr($endpoint, 1);                // remove the leading /
		$query_string = strpos($endpoint, '?');
		
		if($query_string !== false)                          // we have a query string to remove
		{
			$endpoint = substr($endpoint, 0, $query_string);
		}
		
		return $endpoint;
	}
	
	public static function databaseForId($id)
	{
		$id = str_replace('.', ':', $id);
		return $id;
	}
	
	public static function applicationIdForChannelId($id)
	{
		$value    = null;
		$position = strrpos($id, '.');
		
		if($position !== false)
		{
			$value = substr($id, 0, $position);
		}
		
		return $value;
	}
	
	public static function database($type=GalaxyAPIConstants::kDatabaseCouchDB, $database=null, $options=null)
	{
		$db = null;
		
		switch($type)
		{
			case GalaxyAPIConstants::kDatabaseMongoDB:
				$db = self::database_mongodb($database, $options);
				break;
				
			case GalaxyAPIConstants::kDatabaseRedis:
				$db = self::database_redis($database, $options);
				break;
			
			default:
				$db = self::database_mongodb($database, $options);
				break;
		}
		
		return $db;
	}
	
	private static function database_mongodb($database=null, $options=null)
	{
		$connection  = new Mongo();
		$default     = GalaxyAPIConstants::kDatabaseDefault;
		
		if($options){
			$default = isset($options['default']) ? $options['default'] : $default;
		}
		
		$db          = $connection->selectDB($default);
		
		if($database){
			
			$db = $db->selectCollection($database);
		}
		
		return $db;
	}
	
	private static function database_redis($database=null, $options=null)
	{
		$options = array( 'host'     => '127.0.0.1', 
		                  'port'     => 6379, 
		                  'database' => $database ? $database : 0
		);
		
		// php 5.3 exclusively (namespaces and whatnot)
		$db = Predis\Client::create($options);
		return $db;
	}
	
	public static function datetime($value=null)
	{
		$datetime = new DateTime($value);
		return $datetime->format(DateTime::ISO8601);
	}
	
	public function __construct()
	{
		$this->handleRequest();
	}
	
	
	private function handleRequest()
	{
		new GalaxyRequest();
	}
}
?>