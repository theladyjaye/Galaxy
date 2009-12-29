<?php
class Register
{
	public static function Control($alias, $file)
	{
		$control = null;
		$control_path = $_SERVER['DOCUMENT_ROOT']."/application/controls/".$file;
		$function     = "
		
		function ".$alias."(){
			\$control = null;
			\$arguments = func_get_args();
			require \"".$control_path."\"; }";
		
		eval($function);
	}
}

class Control
{
	public static function CodeBehind($class, &$control, &$argv)
	{
		// spl_object_hash()
		// argv and argc are reserved in PHP, but this concept is the same.
		
		$argc        = count($argv);
		$application = PHPApplication::sharedApplication();
		
		require $_SERVER['DOCUMENT_ROOT']."/application/controls/".$class;

		$class   = substr($class, 0, strrpos($class, '.'));
		$control = new $class($argc, $argv);
	}
}

abstract class UserControl
{
	public $page;
	
	public function __construct($argc=0, $argv=null)
	{
		global $page;
		$this->page =& $page;
		$this->page_load($argc, $argv);
	}
	
	protected abstract function page_load($argc=0, $argv=null);
}
	
?>