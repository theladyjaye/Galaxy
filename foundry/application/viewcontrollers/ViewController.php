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
 *    @subpackage viewcontrollers
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class ViewController extends Page
{
	public $session;
	protected $requiresAuthorization  = false;
	protected $hasAuthorizedUser      = false;
	
	protected function page_load() 
	{
		$this->hasAuthorizedUser = Renegade::hasAuthorizedUser();
		
		if($this->requiresAuthorization && !$this->hasAuthorizedUser)
		{
			header('Location: /');
		}
		
		$this->session = Renegade::session();
		$this->initialize();
	}
	
	protected function initialize() { }
	
	public function mustache()
	{
		echo '<script type="text/javascript" charset="utf-8" src="/resources/javascript/mustache/mustache.js"></script>'."\n";
	}
	public function jquery()
	{
		echo '<script type="text/javascript" charset="utf-8" src="/resources/javascript/jquery/jquery-1.3.2.min.js"></script>'."\n";
	}
	
	public function forms()
	{
		echo "\t".'<script type="text/javascript" charset="utf-8" src="/resources/javascript/jquery/jquery.validate.pack.js"></script>'."\n";
		echo "\t".'<script type="text/javascript" charset="utf-8" src="/resources/javascript/jquery/jquery.form.js"></script>'."\n";
	}
	
	public function javascript() 
	{
		$this->mustache();
		if(!$this->hasAuthorizedUser)
		{
			$this->jquery();
			$this->forms();
			echo "\t".'<script type="text/javascript" charset="utf-8" src="/resources/javascript/unauthorized.js"></script>'."\n";
			echo "\t".'<script type="text/javascript" charset="utf-8" src="/resources/javascript/dialog.js"></script>'."\n";
		}
	}
	
	public function css() 
	{
		if(!$this->hasAuthorizedUser)
		{
			echo '<link rel="stylesheet" href="/resources/css/unauthorized.css" type="text/css" media="screen" charset="utf-8">'."\n";
			echo '<link rel="stylesheet" href="/resources/css/dialog.css" type="text/css" media="screen" charset="utf-8">'."\n";
		}
	}
	
}
?>