<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/couchdb/CouchDB.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Channel.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Application.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMInputValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/UniqueChannelValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';


function form_prepare(&$item, $key)
{
	$item = trim($item);
	
	if($key == 'inputId')
	{
		$item = strtolower($item);
	}
}


if(count($_POST))
{
	$session = Renegade::session();
	if(strlen($session->user) > 0)
	{
		array_walk($_POST, 'form_prepare');
		
		$context = array(AMForm::kDataKey => $_POST);
		$form    = AMForm::formWithContext($context);
		
		$form->addValidator(new AMInputValidator('inputName', true, 4, null, 'Channel Name must be at least 4 characters long'));
		$form->addValidator(new AMPatternValidator('inputName', true, '/^[\w ]+$/', 'Application Name may only container letters, numbers, spaces or _'));
		$form->addValidator(new AMPatternValidator('inputType', true, '/^forum$/', 'Invalid Application Type'));
		$form->addValidator(new ApplicationIdValidator('inputId', true, 'Invalid application id.  Please use reverse domain name style starting with com, net, org or edu e.g., com.galaxy.community'));
		
		if($form->isValid)
		{
			// The data for an application is sored in MongoDB, the rest is in Redis
			/* this is a 2 part process
				Part 1: We need to create the auth info for the application
				because this will be being used for access, and potentially MANY calls
				it has to be fast, so we will store the auth token in Redis.
				
				Part 2: So users can manage their applications we will also store a reference
				in couchdb so we can generate a list of applications for them to browser.
				The CouchDB record will hold the key in redis to get the auth tokens. This will probably
				not be under heavy usage, so the slower couchdb is fine. Basically CouchDB will get the metadata
				of the application
			*/
			
			$application = new Application($form->inputId);
			$application->setApplicationOwner($session->user);
			$application->setDescription($form->inputName);
			$application->setApplicationType($form->inputType);
			$application->setDefaultPermissions($form->inputRead|$form->inputWrite);
			$certificate = $application->generate_certificate();
			
			if($certificate)
			{
				$metadata = $application->generate_metadata();
				$redis    = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
				$mongodb  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
				
				$mongodb->insert($metadata);
				$redis->set($certificate['key'], json_encode($certificate['value']));
			}
			
			header('Location:/applications');
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
}
else
{
	header('Location: /');
}
?>