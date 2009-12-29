<?php
class Account extends ViewController
{
	protected $requiresAuthorization  = true;
	
	protected function initialize()
	{

	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
	
	public function authorizedUser()
	{
		$session = Renegade::session();
		return $session->user;
	}
}
?>