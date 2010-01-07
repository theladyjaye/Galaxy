<?php
require 'ConstellationHandler.php';
class Application
{
	public  $constellation;
	private $constellation_handler;
	
	private static $application;
	
	public static function sharedApplication()
	{
		return self::$application;
	}
	
	public function __construct()
	{
		self::$application = $this;
	}
	
	public function initializeConstellation()
	{
		if(!$this->constellation)
		{
			$this->constellation         = new Constellation();
			$this->constellation_handler = new ConstellationHandler();
			$this->constellation->setDelegate($this->constellation_handler);
		}
	}
}
?>