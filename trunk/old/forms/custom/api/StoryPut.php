<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/Form.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/IFormDelegate.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/InputValidator.php';

class StoryPut implements IFormDelegate
{
	private $form;
	
	public function __construct($context)
	{
		$context = json_decode($context, true);
		
		$validation = array();
		$validation['title']       = true;
		$validation['description'] = true;
		$validation['link']        = true;
		$validation['language']    = true;
		$validation['copyright']   = true;
		$validation['author']      = true;
		$validation['consumer']    = true;
		
		$data       = array_intersect_key($context, $validation);
		$this->form = Form::formWithArrayAndDelegate($data, $this);
	}
	
	public function process()
	{
		$this->form->process();
	}
	
	public function formData()
	{
		return $this->form->formData;
	}
	
	public function isValid()
	{
		return $this->form->isValid;
	}
	
	public function willProcessForm(&$form)
	{
		$form->addValidator(new InputValidator($form, 'title', true, 4, 200, null, LocalizedStringForKey("ErrorApplicationNameFormat")));
		$form->addValidator(new InputValidator($form, 'description', true, 4, 200, null, LocalizedStringForKey("ErrorApplicationNameFormat")));
		$form->addValidator(new InputValidator($form, 'link', true, 4, 200, null, LocalizedStringForKey("ErrorApplicationNameFormat")));
		$form->addValidator(new InputValidator($form, 'consumer', true, 32, 32, '/^[\w\d]{32}$/', LocalizedStringForKey("ErrorApplicationNameFormat")));
	}
	
	public function didProcessForm(&$form)
	{
		/*if($form->isValid)
		{
			$this->action($form);
		}
		else
		{
			$this->prepareErrors($form);
		}*/
	}
}
?>