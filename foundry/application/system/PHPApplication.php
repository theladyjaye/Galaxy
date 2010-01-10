<?php
class PHPApplicationSettings
{
	private static $settings;
	
	public static function sharedSettings()
	{
		return PHPApplicationSettings::$settings;
	}
	
	public function __construct()
	{
		if(!PHPApplicationSettings::$settings){
			PHPApplicationSettings::$settings = parse_ini_file('settings.ini', true);
		}
	}
}

class PHPApplication
{
	public $settings;
	
	private $delegate;
	
	private static $application;
	
	public static function sharedApplication()
	{
		return PHPApplication::$application;
	}
	
	public function __construct()
	{
		PHPApplication::$application = $this;
		new PHPApplicationSettings();
		
		$this->settings  = PHPApplicationSettings::sharedSettings();
		
		if(isset($this->settings['application']['delegate']))
		{
			$this->delegate = new $this->settings['application']['delegate']();
			
			if($this->delegate && method_exists($this->delegate,'applicationDidFinishLaunching')){
				$this->delegate->applicationDidFinishLaunching();
			}
		}
		
		$this->handleRequest();
	}
	
	private function sanitizeRequest(&$request)
	{
		$dir = dirname($request);
		if(!in_array($dir, $this->settings['security']['allowed_paths']))
		{
			$prefix = isset($this->settings['application']['views']) ? $this->settings['application']['views'].'/' : null;
			$request = $prefix.$this->settings['application']['default_view'];
		}
	}
	
	private function handleRequest()
	{
		global $page;
		$view = null;
		
		if(isset($_GET['view']))
		{
			$this->sanitizeRequest($_GET['view']);
			
			$prefix = isset($this->settings['application']['views']) ? $this->settings['application']['views'].'/' : null;
			$view   =  $prefix.$_GET['view'];
		}
		else if(isset($_GET['path']))
		{
			$this->sanitizeRequest($_GET['path']);
			$view   = $_GET['path'];
		}
		else
		{
			$end  = strpos($_SERVER['REQUEST_URI'], '?') === false ? strlen($_SERVER['REQUEST_URI']) -1  : strpos($_SERVER['REQUEST_URI'], '?') -1;
			$view = substr($_SERVER['REQUEST_URI'], 1, $end);
			
			if(!$view)
			{
				$prefix = isset($this->settings['application']['views']) ? $this->settings['application']['views'].'/' : null;
				$view = $prefix.$this->settings['application']['default_view'];
			}
			
			$this->sanitizeRequest($view);
		}
		
		if($this->delegate && method_exists($this->delegate,'applicationWillLoadView')){
			$this->delegate->applicationWillLoadView($view);
		}
		
		require $_SERVER['DOCUMENT_ROOT'].'/'.$view;
	}
	
	public function __destruct()
	{
		if($this->delegate && method_exists($this->delegate,'applicationWillTerminate')){
			$this->delegate->applicationWillTerminate();
		}
	}
}
?>