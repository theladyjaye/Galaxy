<?php
function session_currentSession()
{
	static $session;
	
	if(!$session)
	{
		$session = Application::session();
	}
	
	return $session;
}

function session_destroyCurrentSession()
{
	session_currentSession()->reset();
}

function session_regenerateCurrentSession()
{
	session_currentSession()->regenerate(true);
}

function session_formForKey($key)
{
	return session_currentSession()->forms[$key];
}

function session_valueForKey($key)
{
	return session_currentSession()->{$key};
}

function session_setValueForKey($value, $key)
{
	session_currentSession()->{$key} = $value;
}

function session_deleteFormForKey($key)
{
	unset(session_currentSession()->forms[$key]);
}

?>