<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/custom/AccountModify.php';


if(Application::session()->isAuthenticated)
{
	new AccountModify();
}
else
{
	header('location:/');
}


?>