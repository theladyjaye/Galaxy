<?php
class Renegade
{
	const kDatabaseCouchDB      = 1;
	const kDatabaseTokyoCabinet = 2;
	const kDatabaseRedis        = 3;
	
	const kDatabaseUsers        = 0;
	const kDatabaseSessions     = 1;
	const kDatabaseVerification = 2;
	const kDatabaseApplications = 3;
	const kDatabaseChannels     = 'renegade';
	
	// trying to keep the prefixes all in one place
	// might make more sense to store them in their individual objects though.
	// for ease of configuration though they are here for now.
	const kTypeVerification     = 'verify';
	const kTypeSession          = 'session';
	const kTypeUser             = 'user';
	const kTypeChannel          = 'channel';
	const kTypeApplication      = 'app';
	
	const kSessionKey           = 'Renegade';
	const kChannelPrefix        = 'renegade/channels';
	
	
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