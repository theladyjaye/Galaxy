<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/models/User.php';

if(isset($_GET['key']))
{
	$verified = User::verifyWithKey($_GET['key']);
	if($verified)
	{
		// SUCCESS
		echo 'SUCCESS!';
		//header('Location: /?verified=true');
	}
	else
	{
		// FAIL
		echo 'FAILED!';
		//header('Location: /?verified=false');
	}
}
else
{
	// NO KEY
	echo 'no key!';
	//header('Location: /?verified=false');
}

?>