<?php

require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';

class Permissions extends ViewController
{
	protected $requiresAuthorization  = true;
	public $application;
	
	protected function initialize()
	{
		$context = array(AMForm::kDataKey => $_GET);
		$form = AMForm::formWithContext($context);
		$form->addValidator(new ApplicationIdValidator('id', true, 'Invalid application id'));
		
		if($form->isValid)
		{
			$id            = $_GET['id'];
			$applications  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
			$app           = $applications->findOne(array('_id' => $id, 'owner' => $this->session->user));
			
			if(!$app){
				Renegade::redirect('/applications');
			}
			$this->application = $app;
			
			
		}
		else
		{
			Renegade::redirect('/applications');
		}
	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
	
	public function defaultPermissionRead()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionRead) ? 'checked' : '';
	}
	
	public function defaultPermissionWrite()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionWrite) ? 'checked' : '';
	}
	
	public function defaultPermissionDelete()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionDelete) ? 'checked' : '';
	}
}
?>