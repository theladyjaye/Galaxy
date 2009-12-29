<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMEmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';

if(count($_POST))
{
	$context = array(AMForm::kDataKey => $_POST);
	$form    = AMForm::formWithContext($context);
	
	
	$form->addValidator(new AMPatternValidator('inputPassword', true, '/^[\S]{4,}$/', 'Invalid password'));
	
	$isEmail = false;
	
	if(strpos($form->inputName, '@') !== false)
	{
		$form->addValidator(new AMEmailValidator('inputName', true, 'Invalid username'));
		$isEmail = true;
	}
	else
	{
		$form->addValidator(new AMPatternValidator('inputName', true, '/^[\w]{4,}$/', 'Invalid username'));
	}

	if($form->isValid)
	{
		$valid    = false;
		
		$name      = strtolower(trim($form->inputName));
		$password  = renegade_security_hash(trim($form->inputPassword));
		

		$db        = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseUsers);
		$key       = RenegadeConstants::kTypeUser.':'.$name;
		$user      = array('ok'=>false, 'error'=>'invalid user');
		$data      = null;
		
		if($isEmail)
		{
			$key = json_decode($db->get($key));
			
			if($key)
			{
				$name = $key;
				$key  = RenegadeConstants::kTypeUser.':'.$key;
				$data = $db->get($key);
			}
		}
		else
		{
			$data = $db->get($key);
		}
		
		
		if($data)
		{
			$user = json_decode($data, true);
			
			if($user['verified'] == true)
			{
				if($password == $user['password'])
				{
					// SUCCESS
					Renegade::authorizeUser($name);
					header('Location: /');
				}
				else
				{
					// INVALID PASSWORD
					echo 'invalid password';
				}
			}
			else
			{
				// NOT VERIFIED
				// the user is valid, and they provided the proper credentials, 
				// but they are not verified by their e-mail address
				
				echo 'user not verified';
			}
		}
		else
		{
			// NO USER
			echo 'no such user';
		}
	}
	else
	{
		// INVALID INPUT
		echo 'form input invalid';
		/*foreach($form->validators as $v)
		{
			if($v->isValid == false)
			{
				echo $v->message."<br>";
			}
		}*/
	}
	
	
}
?>