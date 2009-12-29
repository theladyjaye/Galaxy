<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/couchdb/CouchDB.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';

function form_prepare(&$item, $key)
{
	$item = trim($item);
	$item = strtolower($item);
}


if(count($_POST))
{
	$session = Renegade::session();
	if(strlen($session->user) > 0)
	{
		array_walk($_POST, 'form_prepare');
		
		$context = array(AMForm::kDataKey => $_POST);
		$form    = AMForm::formWithContext($context);
		
		$form->addValidator(new AMPatternValidator('inputCertificate', true, '/^'.RenegadeConstants::kTypeCertificate.':[a-z0-9]{32,32}$/', 'Invalid Certificate'));
		$form->addValidator(new ApplicationIdValidator('inputId', true, 'Invalid application id'));
		
		if($form->isValid)
		{
			$mongodb  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
			$redis    = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
			
			$mongodb->remove(array('_id' => $form->inputId));
			$redis->delete($form->inputCertificate);
		}
	}
}

header('Location:/applications');
?>