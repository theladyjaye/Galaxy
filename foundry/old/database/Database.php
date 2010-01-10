<?php
class Database
{
	public static function connection()
	{
		return new CouchDB(array('database' => Configuration::kDatabaseName));
		//return new PDO(Configuration::kDatabaseType.':host='.Configuration::kDatabaseHost.';dbname='.Configuration::kDatabaseName, Configuration::kDatabaseUsername, Configuration::kDatabasePassword);
	}
}
?>