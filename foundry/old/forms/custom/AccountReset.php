<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/EmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/EmailFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/UserFunctions.php';

class AccountReset implements IFormDelegate
{
	function __construct() 
	{
		if($_POST[__CLASS__])
		{
			$form = Form::formWithArrayAndDelegate($_POST[__CLASS__], $this);
			$form->process();
		}
	}
	
	public function willProcessForm(&$form)
	{
		$form->email = filter_var($form->email, FILTER_SANITIZE_EMAIL);
		//$form->addValidator(new EmailValidator($form->email, true, LocalizedStringForKey("ErrorEmailFormat")));
	}
	
	public function didProcessForm(&$form)
	{
		if($form->isValid)
		{
			$this->action($form);
		}
		else
		{
			$this->prepareErrors($form);
		}
	}
	
	private function prepareErrors($form)
	{
		$messages = array();
		
		foreach($form->validators as $validator)
		{
			if(!$validator->isValid)
			{
				$messages[$validator->key] = $validator->message;
			}
		}
		
		//$session = Application::session();
		$session = session_currentSession();
		$session->forms[__CLASS__]['messages'] = $messages;
		$session->forms[__CLASS__]['form']     = $form;
		
		header('location:/forgetful/');
	}
	
	private function action($form)
	{
		$user = user_userForEmail($form->email);
		
		if($user)
		{
			$newPassword    = $this->generatePassword();
			$user->password = $newPassword;
			$user->save();
			
			$email                 = array();
			$email['recipients'][] = $user->username;
			$email['new_password'] = $newPassword;
			
			email_sendAccountReset($email);
		}
		
		header('location:/forgetful/no_more/');
	}
	
	private function generatePassword()
	{
		//$base   = "_-!*$@<>?0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$base   = "_!$@?0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$string = "";
		$i      = 0;

		while ($i < 8) 
		{ 
			$char = substr($base, mt_rand(0, strlen($base)-1), 1);

			if (!strstr($string, $char)) 
			{ 
				$string .= $char;
				$i++;
			}
		}

		return $string;
	}
}
?>