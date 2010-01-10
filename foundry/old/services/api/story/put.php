<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/services/api/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/custom/api/StoryPut.php';

$request       = new RenegadeRequest();

if($request->isAuthorized)
{
	$input       = fopen("php://input", "r");
	$document    = stream_get_contents($input);
	fclose($input);

	$form        = new StoryPut($document);
	$form->process();

	if($form->isValid())
	{
		$filename    = basename($_SERVER['REQUEST_URI']);
		$data = $form->formData();

		if(!isset($data['language'])){
			$data['language'] = 'en';
		}

		$data['type'] = Configuration::kStoryType; 
		$data         = json_encode($data);

		$db           = Application::database();
		$result       = $db->put($data, $filename);

		unset($result['ok']);
		unset($result['rev']);

		echo json_encode($result);
	}
	else
	{
		$error = array('error'=> 'Invalid Story');
		echo json_encode($error);
	}
	
}
else
{
	$error = array('error'=> 'Not Authorized');
	echo json_encode($error);
}
?>