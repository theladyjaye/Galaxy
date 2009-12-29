<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/EmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/MatchValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/InputValidator.php';
//require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/PHORMUniqueRecordValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/UniqueEmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/UniqueScreennameValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/EmailFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/UserFunctions.php';

class AccountCreate implements IFormDelegate
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
		$form->addValidator(new EmailValidator($form->email, true, LocalizedStringForKey("ErrorEmailFormat")));
		$form->addValidator(new InputValidator($form->password, true, 5, 16, '/^[\w!\(\)\^\*\$#@\%\&\<\>\?]+$/', LocalizedStringForKey("ErrorPasswordFormat")));
		$form->addValidator(new MatchValidator($form->password, $form->password_confirm, true, LocalizedStringForKey("ErrorPasswordMatch")));
		$form->addValidator(new InputValidator($form->screenname, true, 4, 16, '/^[\w]+$/', LocalizedStringForKey("ErrorScreennameFormat")));
		$form->addValidator(new UniqueEmailValidator($form->email, true, LocalizedStringForKey("ErrorEmailUnique")));
		$form->addValidator(new UniqueScreennameValidator($form->screenname, true, LocalizedStringForKey("ErrorScreennameUnique")));
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
		header('location:/registration');
	}
	
	private function action($form)
	{
		$u                       = new User();
		$u->username             = strtolower($form->email);
		$u->screenname           = $form->screenname;
		$u->password             = $form->password;
		$u->lastLogin            = time();
		$u->isValid              = false;
		
		$u->columns['bitmap_normal']->value = User::kProfileDefaultNormal;
		$u->columns['bitmap_bigger']->value = User::kProfileDefaultBigger;
		
		$u->save();
		
		
		
		//echo $u->bitmap_normal;
		//exit;
		
		//$session = Application::session();
		//$session->regenerate(true);
		//$session->id              = $u->id;
		//$session->screenname      = $u->screenname;
		//$session->isAuthenticated = true;
		
		$session = session_currentSession();
		session_regenerateCurrentSession();
		
		session_setValueForKey($u->id, 'id');
		session_setValueForKey($u->screenname, 'screenname');
		session_setValueForKey(true, 'isAuthenticated');
		
		// generate a random key for the user to authenticate against:
		$stream = fopen('/dev/random', 'r');
		$bytes = fread($stream, 512);
		fclose($stream);
		
		$key        = hash('md5', base64_encode($bytes));
		
		$authorized = array('type'=>'authorization', 'user'=>$u->id, 'key'=>$key);
		$db = new CouchDB(array('database'=>Configuration::kDatabaseName));
		$db->put(json_encode($authorized));
		
		
		$email                 = array();
		$email['recipients'][] = $u->username;
		$email['key']          = $key;
		
		email_sendAccountCreate($email);
		
		header('location:/');
	}
}
?>