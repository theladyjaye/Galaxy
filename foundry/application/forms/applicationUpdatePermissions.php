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
 *    @subpackage forms
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';

$session = Renegade::session();

if(count($_POST))
{
	$session = Renegade::session();
	
	if(strlen($session->user) > 0)
	{
		$context = array(AMForm::kDataKey => $_POST);
		$form    = AMForm::formWithContext($context);
		$form->addValidator(new ApplicationIdValidator('inputApplicationId', true, 'Invalid application id'));

		if($form->isValid)
		{
			$applications  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
			$app           = $applications->findOne(array('_id' => $form->inputApplicationId, 'owner' => $session->user));
	
			if(!$app)
			{
				Renegade::redirect('/applications');
			}
			else
			{
				$read        = $form->inputRead   ? RenegadeConstants::kPermissionRead   : 0;
				$write       = $form->inputWrite  ? RenegadeConstants::kPermissionWrite  : 0;
				$delete      = $form->inputDelete ? RenegadeConstants::kPermissionDelete : 0;
				
				
				$app['defaultPermissions'] = $read|$write|$delete;
				$applications->update(array('_id' => $app['_id']), $app);
			}
		}
	}
}
Renegade::redirect('/applications');
?>