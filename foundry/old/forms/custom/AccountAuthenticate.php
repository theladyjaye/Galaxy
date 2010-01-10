<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';

class AccountAuthenticate implements IFormDelegate
{
	function __construct() 
	{
		if($_POST[__CLASS__])
		{
			$form = Form::formWithArrayAndDelegate($_POST[__CLASS__], $this);
			$form->process();
		}
		else
		{
			$this->prepareErrors();
		}
	}
	
	public function willProcessForm(&$form)
	{
		if(strpos($form->username, '@') != 0)
		{
			$form->username = filter_var($form->username, FILTER_SANITIZE_EMAIL);
		}
	}
	
	public function didProcessForm(&$form)
	{
		if(strpos($form->username, '@') === false)
		{
			$this->authenticateWithScreenname($form);
		}
		else
		{
			$this->authenticateWithEmail($form);
		}
	}
	
	private function authenticateWithScreenname($form)
	{
		$user = user_userForName($form->username);
		if($user)
		{
			$this->authenticateWithUserAndPassword($user, $form->password);
			$user->release();
		}
		else
		{
			$this->prepareErrors();
		}
	}
	
	private function authenticateWithEmail($form)
	{
		$user = user_userForEmail($form->username);
		if($user)
		{
			$this->authenticateWithUserAndPassword($user, $form->password);
			$user->release();
		}
		else
		{
			$this->prepareErrors();
		}
	}
	
	private function authenticateWithUserAndPassword(User &$user, $password)
	{
		if($user->password == md5($password))
		{
			$this->action($user);
		}
		else
		{
			$this->prepareErrors();
		}
	}
	
	private function prepareErrors()
	{
		$messages = array();
		$messages['authentication'] = LocalizedStringForKey("ErrorAuthentication");
		
		$session = session_currentSession();
		$session->forms[__CLASS__]['messages'] = $messages;

		header('location:/');
	}
	
	private function action($user)
	{
		$session = session_currentSession();
		session_regenerateCurrentSession();
	
		
		session_setValueForKey($user->id,           'id');
		session_setValueForKey($user->screenname,   'screenname');
		session_setValueForKey($user->isValid,      'isValid');
		session_setValueForKey(true,                'isAuthenticated');
		
		//$session->id              = $user->id;
		//$session->screenname      = $user->screenname;
		//$session->isAuthenticated = true;
		
		$user->lastLogin          = time();
		$user->save();
		
		header('location:/account/channels');
	}
}
?>