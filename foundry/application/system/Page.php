<?php
$page = null;

abstract class Page
{
	
	public $isPostBack                = false;
	
	public static function CodeBehind($class)
	{
		global $page;
		
		$settings    = PHPApplicationSettings::sharedSettings();
		require $_SERVER['DOCUMENT_ROOT'].'/'.$settings['application']['controllers'].'/'.$class;
		
		$class = substr($class, 0, strrpos($class, '.'));
		
		$page = new $class();
	}
	
	public function __construct()
	{
		if(count($_POST))
		{
			$this->isPostBack = true;
		}
		
		$this->page_load();
	}
	
	protected abstract function page_load();
}
?>