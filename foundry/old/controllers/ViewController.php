<?php 
class ViewController extends Page
{
	protected function page_load()
	{
		
	}
	
	protected function authenticate()
	{
		if(!Application::session()->isAuthenticated){
			$this->willRedirectToAuthenticationPage();
		}
	}
	
	protected function willRedirectToAuthenticationPage()
	{
		header("location: /");
	}
}

?>