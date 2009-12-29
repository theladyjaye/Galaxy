<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ErrorMessage.php';

class PasswordResetViewController extends ViewController
{
	public $form;
	public $messages;
	
	protected function page_load()
	{
		$session = Application::session();
		
		if(isset($session->forms['AccountReset']))
		{
			$this->form     = $session->forms['AccountReset']['form'];
			$this->messages = $session->forms['AccountReset']['messages'];
			
			unset($session->forms['AccountReset']);
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