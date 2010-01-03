<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMInputValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Channel.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Subscription.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Application.php';


function form_prepare(&$item, $key)
{
	$item = trim($item);
	
	switch($key)
	{
		case 'inputId':
		case 'inputCertificate':
		case 'inputApplicationId':
			$item = strtolower($item);
			break;
	}
}

$session = Renegade::session();
if(strlen($session->user) > 0 && count($_POST))
{
	array_walk($_POST, 'form_prepare');
	
	$context = array(AMForm::kDataKey => $_POST);
	$form    = AMForm::formWithContext($context);
	
	$pattern_certificate = '/^'.RenegadeConstants::kTypeCertificate.':[a-z0-9]{32}$/';
	
	$form->addValidator(new AMInputValidator('inputDescription', true, 4, null, 'Channel Description must be at least 4 characters long'));
	$form->addValidator(new AMPatternValidator('inputLabel', true, '/^[\w -]+$/', 'Channel Name may only container letters, numbers, spaces, underscores or hyphens'));
	$form->addValidator(new AMPatternValidator('inputId', true, '/^[a-z0-9][a-z0-9-]+$/', 'Channel Id may only container letters, numbers, or hyphens.  It cannot begin with a hyphen'));
	$form->addValidator(new AMPatternValidator('inputCertificate', true, $pattern_certificate, 'Invalid certificate'));
	$form->addValidator(new ApplicationIdValidator('inputApplicationId', true, 'Invalid application id'));

	if($form->isValid)
	{
		// make sure we are authorized to create the channel for this application
		$mongodb     = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
		$redis       = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
		$certificate = json_decode($redis->get($form->inputCertificate), true);
		$data        = $mongodb->findOne(array('_id' => $form->inputApplicationId));
		
		if($data['owner'] == $session->user && $certificate['owner'] == $session->user)
		{
			// create the channel
			$channel = new Channel($form->inputId);
			$channel->setCertificate($form->inputCertificate);
			$channel->setApplication($form->inputApplicationId);
			$channel->setLabel($form->inputLabel);
			$channel->setDescription($form->inputDescription);
			$channel->setDefaultPermissions((int)$form->inputRead|(int)$form->inputWrite|(int)$form->inputDelete);
			
			// channel owner gets all permissions by default
			$certificate  = $channel->generate_certificate(RenegadeConstants::kPermissionRead|RenegadeConstants::kPermissionWrite|RenegadeConstants::kPermissionDelete);
			$metadata     = $channel->generate_metadata();
			
			$subscription = new Subscription();
			$subscription->setCertificate($certificate['key']);
			$subscription->setApplication($metadata['application']);
			$subscription->setChannel($metadata['_id']);
			$subscription->setMaster(true);
		
			// place us in the application db context
			$options       = array('default' => Renegade::databaseForId($form->inputApplicationId));
			$channels      = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options);
			$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options);
			
			$redis->set($certificate['key'], $certificate['value']);
			$channels->insert($metadata);
			$subscriptions->insert($subscription->toArray());
		}
		else
		{
			// error, something is potentially wrong, either from the user or the system
			// lets assume the system, it's easy to throw guilt at the user =)
			echo 'Error';exit;
			header('Location: /applications');
			exit;
		}
		
		header('Location:/applications/'.$form->inputApplicationId.'/channels');
		exit;
	}
	else
	{
		foreach($form->validators as $validator)
		{
			if($validator->isValid == false)
			{
				echo $validator->message."\n";
			}
		}
	}
}
else
{
	header('Location: /');
}
?>