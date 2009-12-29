<?php
class Application
{
	public static function current_language()
	{
		return 'en';
	}
	
	public static function current_user()
	{
		return user_currentUser();
	}
	
	public static function session()
	{
		$session = null;
		
		if(isset($_SESSION[Configuration::kSessionKey]))
		{
			$session = unserialize($_SESSION[Configuration::kSessionKey]);
		}
		else
		{
			$session = new Session();
		}
		
		return $session;
	}
}
?>