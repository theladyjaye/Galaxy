<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/InputValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/DomainValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/ApplicationShortNameValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/custom/UniqueApplicationShortNameValidator.php';


class ChannelCreate implements IFormDelegate
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
		$form->addValidator(new DomainValidator($form->domain, true, LocalizedStringForKey("ErrorDomainNameFormat")));
		$form->addValidator(new ApplicationShortNameValidator($form->shortname, true, LocalizedStringForKey("ErrorApplicationShortNameFormat")));
		$form->addValidator(new UniqueApplicationShortNameValidator($form->shortname, true, LocalizedStringForKey("ErrorApplicationShortNameUnique")));
		$form->addValidator(new InputValidator($form->name, true, 4, 100, '/^[^\s]+[\w\s\d]+$/', LocalizedStringForKey("ErrorApplicationNameFormat")));
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
		
		//header('location:/account/settings');
	}
	
	private function generateKey($salt=null)
	{
		$stream = fopen('/dev/random', 'rb');
		
		if($stream)
		{
			$data   = fread($stream, 512);
			fclose($stream);
			return  hash('md5', base64_encode($data).$salt.uniqid(mt_rand(), true));
		}
	}
	
	private function generateSecret($salt=null)
	{
		$stream = fopen('/dev/random', 'rb');
		
		if($stream)
		{
			$data   = fread($stream, 512);
			fclose($stream);
			return  hash('md5', base64_encode($data).$salt.uniqid(mt_rand(), true));
		}
	}
	
	private function action($form)
	{
		$session = session_currentSession();
		
		$p                       = new Channel();
		
		$p->user                 = $session->id;
		$p->label                = $form->name;
		$p->short_label          = $form->shortname;
		$p->key                  = $this->generateKey();
		$p->secret               = $this->generateSecret();
		$p->domain               = $form->domain;
		
		// ISO-8601 2005-08-14T16:13:03+0000;
		$time = time() + $value;
		$p->created              = date('c', $time);
		
		$p->save();
		
		//header('location:/account/settings');
	}
}
?>