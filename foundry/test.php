<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/mail/phpmailer/class.phpmailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/User.php';
$connection  = new Mongo();
$db = $connection->selectDB('galaxy');
$collection = $db->selectCollection('applications');
$collection->insert(array(
	                     ));
var_dump($collection);
echo $collection->count();

/*
$user = new User();
$user->email = 'aventurella@gmail.com';
$user->pasword = 'bassett314';
$json = serialize($user);

$o = unserialize($json);
print_r($o);
*/
/*$mail             = new PHPMailer();
$mail->SetFrom('test@test.com', 'Project Test');
$mail->Subject    = 'Hello!';
$mail->Body       = 'Test E-mail';
$mail->AddAddress('aventurella@gmail.com');


$mail->Send();*/

?>