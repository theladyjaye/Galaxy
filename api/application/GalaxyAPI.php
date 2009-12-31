<?php
class GalaxyAPI
{
	public static function databaseForId($id)
	{
		$id = str_replace('.', ':', $id);
		return $id;
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