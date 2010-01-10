<?php

class RenegadeSession
{
	private static $session = null;
	private static $handle;
	private static $lifetime;
	
	/* <session_handler> */
	public static function open()
	{
		$db             = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseSessions);
		self::$handle   = $db;
		self::$lifetime = ini_get('session.gc_maxlifetime');
		return true;
	}

	public static function read($id)
	{
		$key = self::sessionKeyForId($id);
		return self::$handle->get($key);
	}

	public static function write($id, $data)
	{
		$key = self::sessionKeyForId($id);
		return self::$handle->set($key, $data);
		return self::$handle->expire($key, self::$lifetime);
	}

	public static function destroy($id)
	{
		$key = self::sessionKeyForId($id);
		return self::$handle->delete($key);
	}
	
	public static function gc(){ return true; }
	public static function close(){return true; }
	
	/* </session_handler> */

	private static function sessionKeyForId($id)
	{
		return RenegadeConstants::kTypeSession.':'.$id;
	}
	
	public static function sharedSession()
	{
		if(!self::$session)
		{
			self::$session = new RenegadeSession();
		}
		
		return self::$session;
	}
	
	public function __construct(){}
	
	public function reset()
	{
		$_SESSION[RenegadeConstants::kSessionKey] = array();
		
		if (isset($_COOKIE[session_name()])) 
		    setcookie(session_name(), '', time()-42000, '/');
		
		session_destroy();
	}
	
	public function __get($key)
	{
		if(isset($_SESSION[RenegadeConstants::kSessionKey][$key]))
			return $_SESSION[RenegadeConstants::kSessionKey][$key];
	}
	
	public function __set($key, $value)
	{
		if(isset($_SESSION[RenegadeConstants::kSessionKey][$key]) && $_SESSION[RenegadeConstants::kSessionKey][$key] != $value)
		{
			$_SESSION[RenegadeConstants::kSessionKey][$key] = $value;
		}
		else
		{
			$_SESSION[RenegadeConstants::kSessionKey][$key] = $value;
		}
	}
	
	public function __destruct()
	{
		session_write_close();
	}
}
?>