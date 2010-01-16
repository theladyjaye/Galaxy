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
 *    @subpackage system
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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