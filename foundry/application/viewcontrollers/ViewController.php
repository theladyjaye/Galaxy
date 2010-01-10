<?php
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