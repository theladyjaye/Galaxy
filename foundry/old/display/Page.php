<?php
abstract class Page
{
	protected $authenticationRequired = false;
	public $isPostBack                = false;
	public function __construct()
	{
		if($this->authenticationRequired)
			$this->authenticate();
			
		if(!empty($_POST)){
			$this->isPostBack = true;
		}
		
		$this->page_load();
	}
	
	protected abstract function page_load();
	protected abstract function authenticate();
}
?>