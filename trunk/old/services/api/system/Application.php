<?php
class Application
{
	public static function current_language()
	{
		return 'en';
	}
	
	public static function database()
	{
		$options = array();
		$options['database'] = Configuration::kDatabaseName;
		$options['host']     = Configuration::kDatabaseHost;
		$options['port']     = Configuration::kDatabasePort;
		
		$db = new CouchDB($options);
		
		return $db;
	}
}
?>