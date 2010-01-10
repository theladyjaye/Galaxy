<?php
class Configuration
{
	const kDatabaseType         = 'couchdb';
	
	/* MySQL */
	/*
	const kDatabaseHost         = 'localhost';
	const kDatabaseName         = 'newspaper';
	const kDatabaseUsername     = 'root';
	const kDatabasePassword     = '';
	*/
	
	/* CouchDB */
	const kDatabaseName         = 'renegade';
	const kDatabaseHost         = '127.0.0.1';
	const kDatabasePort         = '5984';
	const kDatabaseUsername     = '';
	const kDatabasePassword     = '';
	
	const kSessionKey           = 'Session';
	
	const kResourcePath = '/application/resources/';
}
?>