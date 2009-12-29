<?php
class Session
{
	public $lastLocation;
	public $isAuthenticated;
	public $isValid;
	public $id;
	public $screenname;
	
	public $forms = array();
	
	public function __destruct()
	{
		$this->lastLocation                        = $_SERVER['PHP_SELF'];
		$this->lastQueryString                     = $_GET;
		
		$this->flush();
		//$_SESSION[Configuration::kSessionKey]      = serialize($this);
	}
	
	public function destroy()
	{
		$_SESSION = array();
		
		if (isset($_COOKIE[session_name()])) 
		    setcookie(session_name(), '', time()-42000, '/');
		
		session_destroy();
	}
	
	public function flush()
	{
		$_SESSION[Configuration::kSessionKey]      = serialize($this);
	}
	
	public function stringForLastQueryString()
	{
		$string = '?';
		foreach ($this->lastQueryString as $key=>$value)
		{
			$string .=$key.'='.$value.'&';
		}
		
		return substr($string, -1);
	}
	
	public function regenerate($delete_old_session = false)
	{
		session_regenerate_id($delete_old_session);
	}
}
?>