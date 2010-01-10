<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
$key = filter_var($_GET['key'], FILTER_UNSAFE_RAW);

if(preg_match('/[\w\d]{32}/', $key))
{
	$options       = array('database'=>Configuration::kDatabaseName);
	$db            = new CouchDB($options);
	$query_options = array('key'=> $key);
	
	$result = $db->view('users/accountAuthorization', $query_options);
	
	if(count($result) > 0)
	{
		$authtoken = $result[0]['value']['key'];
		if($authtoken == $key)
		{
			$user = new User();
			$db_user = $db->document($result[0]['value']['user']);
			$user->initWithArray($db_user);
			$user->isValid = true;
			$user->save();
			
			$db->delete($result[0]['value']['_id'], $result[0]['value']['_rev']);
		}
	}
	
	header('location: /');
}

?>