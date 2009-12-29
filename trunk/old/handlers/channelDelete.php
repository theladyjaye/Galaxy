<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';

$db       = Database::connection();
$document = $db->document($_POST['id']);
$response = 0;

if($document)
{
	$document['deleted'] = true;
	$db->put(json_encode($document), $_POST['id']);
	$response =  1;
}

echo $response;

//header('location: /account/settings');

?>