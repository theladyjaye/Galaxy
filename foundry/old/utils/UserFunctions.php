<?php
function user_userForName($name)
{
	$dbh = Database::connection();
	$options = array('key' => $name, 'limit' => 1);
	$view = $dbh->view('users/authenticateScreenname', $options);
	
	$user = null;
	
	if(count($view) > 0)
	{
		$user = new User();
		$user->initWithArray($view[0]['value']);
	}
	
	return $user;
}

function user_userForEmail($email)
{
	$user = null;
	
	$dbh = Database::connection();
	$options = array('key' => $email, 'limit' => 1);
	$view = $dbh->view('users/authenticateEmail', $options);
	
	if(count($view) > 0)
	{
		$user = new User();
		$user->initWithArray($view[0]['value']);
	}
	
	return $user;
}

function user_currentUser()
{
	static $user;
	
	if(!$user)
	{
		$session = Application::session();
		
		if(!empty($session->id))
		{
			$user = new User();
			$user->initWithPrimaryKey($session->id);
		
			if(empty($user->id))
			{
				$user = null;
			}
		}
		else
		{
			$user = null;
		}
	}
	
	return $user;
}
?>