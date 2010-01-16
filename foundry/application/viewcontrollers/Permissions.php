<?php
/**
 *    Galaxy - Foundry
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package foundry
 *    @subpackage viewcontrollers
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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