<?php
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