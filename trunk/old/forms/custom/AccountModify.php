<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/EmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/MatchValidator.php';
//require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/PHORMUniqueRecordValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/UniqueEmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/InputValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/EmailFunctions.php';

class AccountModify implements IFormDelegate
{
	private $shouldUpdateEmail;
	private $shouldUpdatePassword;
	private $shouldUpdatePhoto;
	
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
		 
		if(!empty($form->formData['email']) && !empty($form->formData['email_confirm']))
		{
			$this->shouldUpdateEmail = true;
			$form->addValidator(new EmailValidator($form->email, true, LocalizedStringForKey("ErrorEmailFormat")));
			$form->addValidator(new MatchValidator($form->email, $form->email_confirm, true, LocalizedStringForKey("ErrorEmailMatch")));
			$form->addValidator(new UniqueEmailValidator($form->email,  true, LocalizedStringForKey("ErrorEmailUnique")));
		}
		
		if(!empty($form->formData['password']) && !empty($form->formData['password_confirm']))
		{
			$this->shouldUpdatePassword = true;
			$form->addValidator(new InputValidator($form->password, true, 5, 16, '/^[\w!\(\)\^\*\$#@\%\&\<\>\?]+$/', LocalizedStringForKey("ErrorPasswordFormat")));
			$form->addValidator(new MatchValidator($form->password, $form->password_confirm, true, LocalizedStringForKey("ErrorPasswordMatch")));
		}
		
		$photo = $form->photo;
		if(!empty($photo))
		{
			$this->shouldUpdatePhoto = true;
		}
		
		if(!$this->shouldUpdatePassword && !$this->shouldUpdateEmail && !$this->shouldUpdatePhoto)
		{
			header('location:/account/settings');
			exit;
		}
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
		
		header('location:/account/settings');
	}
	
	private function action($form)
	{
		//$session       = Application::session();
		$session       = session_currentSession();
		$id            = session_valueForKey('id'); //$session->id;
		
		if(!empty($id))
		{
			$u             = new User();
			$u->initWithPrimaryKey($id);
		
			//$q             = phorm_query('User');
			//$q->filter('User->id = '.'"'.$id.'"');
		
			//$u             = $q->one();
		
			if(!empty($u->id))
			{
				$email                 = array();
				$email['recipients'][] = $u->username;

			
				if($this->shouldUpdateEmail)
				{
					$u->username           = strtolower($form->email);
					$email['recipients'][] = strtolower($form->email);
				}
			
				if($this->shouldUpdatePassword){
					$u->password   = $form->password;
				}
			
				if($this->shouldUpdatePhoto)
				{
					$u->bitmap_normal   = $form->photo;
					$u->bitmap_bigger   = $form->photo;
				}
			
				$u->save();
				$u->release();
			
				email_sendAccountModify($email);
			
				header('location:/account/settings/success');
			}
			else
			{
				header('location:/account/logout');
			}
		}
	}
}
?>