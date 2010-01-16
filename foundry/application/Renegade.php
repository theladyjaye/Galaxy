<?php
/**
 *    Galaxy - Foundry
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
 *    @package foundry
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class Renegade
{
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
	
	public static function databaseForId($id)
	{
		$id = str_replace('.', ':', $id);
		return $id;
	}
	
	public static function session()
	{
		return RenegadeSession::sharedSession();
	}
	
	public static function authorizedUser()
	{
		static $user = null;
		
		if(!$user)
		{
			$session  = Renegade::session();
			$db       = Renegade::database();
			$response = $db->document($session->user);
		
			if(!isset($user['error']))
			{
				$user = $response;
			}
		}
		
		return $user;
	}
	
	public static function redirect($value=null)
	{
		$value = $value ? $value : '/';
		header('Location:'.$value);
		exit;
	}
	
	public static function unauthorized($value=null)
	{
		self::redirect($value);
	}
	
	public static function datetime($value=null)
	{
		$datetime = new DateTime($value);
		return $datetime->format(DateTime::ISO8601);
	}
	
	public static function authorizeUser($user)
	{
		session_regenerate_id(true);
		$session = Renegade::session();
		$session->user = $user;
	}
	
	public static function hasAuthorizedUser()
	{
		$result  = false;
		
		$session = Renegade::session();
		$key     = $session->user;
		
		if(!empty($key))
		{
			$result = true;
		}
		
		return $result;
	}
	
	public function logout()
	{
		$session = Renegade::session();
		$session->reset();
	}
	
	public static function current_language()
	{
		return 'en_US';
	}
	
	public static function database($type=RenegadeConstants::kDatabaseCouchDB, $database=null, $options=null)
	{
		$db = null;
		
		switch($type)
		{
			case RenegadeConstants::kDatabaseMongoDB:
				$db = self::database_mongodb($database, $options);
				break;
				
			case RenegadeConstants::kDatabaseCouchDB:
				$db = self::database_couchdb($database, $options);
				break;
			
			case RenegadeConstants::kDatabaseRedis:
				$db = self::database_redis($database, $options);
				break;
				
			case RenegadeConstants::kDatabaseTokyoCabinet:
				$db = self::database_tokyocabinet();
				break;
			
			default:
				$db = self::database_couchdb($database, $options);
				break;
		}
		
		return $db;
	}
	
	private static function database_mongodb($database=null, $options=null)
	{
		$connection  = new Mongo();
		$default     = RenegadeConstants::kDatabaseDefault;
		
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
	
	private static function database_tokyocabinet($database=null, $options=null)
	{
		//$db = new TinyGojira();
		//return $db;
		return null;
	}
	
	private static function database_couchdb($database=null, $options=null)
	{
		$settings = PHPApplicationSettings::sharedSettings();
		$options  = array('host'     => $settings['database']['host'],
		                  'port'     => $settings['database']['port'],
		                  'database' => $database ? $database : $settings['database']['database']);
		
		return new CouchDB($options);
	}
	
	public function __construct()
	{
	
	}
	
	/*
	public function applicationDidFinishLaunching()
	{
		echo 10;
	}
	
	public function applicationWillTerminate()
	{
		echo 30;
	}
	
	public function applicationWillLoadView(&$view)
	{
		echo $view;
	}
	*/
}
?>