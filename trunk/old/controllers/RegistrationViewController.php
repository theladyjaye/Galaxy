<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ErrorMessage.php';

class RegistrationViewController extends ViewController
{
	public $form;
	public $messages;
	
	protected function page_load()
	{
		$session = Application::session();
		
		if(isset($session->forms['AccountCreate']))
		{
			$this->form     = $session->forms['AccountCreate']['form'];
			$this->messages = $session->forms['AccountCreate']['messages'];
			unset($session->forms['AccountCreate']);
		}
	}
	
	public function messages()
	{
		if($this->messages)
		{
			foreach($this->messages as $value)
			{
				echo new ErrorMessage($value);
			}
		}
	}
}
?>