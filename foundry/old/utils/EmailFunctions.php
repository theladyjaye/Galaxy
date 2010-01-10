<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/net/phpmailer/class.phpmailer.php';

define('kEmailFromName',             'Project Pogo');
define('kEmailFromAddress',          'pogo@projectpogo.com');
define('kEmailAccountCreateSubject', 'Welcome To Project Pogo!');
define('kEmailAccountModifySubject', 'Project Pogo : Your Account Has Been Modified');
define('kEmailAccountResetSubject',  'Project Pogo : Your Password Has Been Reset');

function email_sendAccountCreate($values)
{
	$values['from_name']    = kEmailFromName;
	$values['from_address'] = kEmailFromAddress;
	$values['subject']      = kEmailWelcomeSubject;
	$values['body']         = strtr(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/email/accountCreate.txt'), array('{key}' => $values['key']));
	
	email_sendAsPlainTextWithArray($values);
}

function email_sendAccountModify($values)
{
	$values['from_name']    = kEmailFromName;
	$values['from_address'] = kEmailFromAddress;
	$values['subject']      = kEmailAccountModifySubject;
	$values['body']         = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/email/accountModify.txt');
	
	email_sendAsPlainTextWithArray($values);
}

function email_sendAccountReset($values)
{
	$values['from_name']    = kEmailFromName;
	$values['from_address'] = kEmailFromAddress;
	$values['subject']      = kEmailAccountResetSubject;
	$values['body']         = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/resources/email/accountReset.txt');
	$values['body']        .= 'New Password: '.$values['new_password'];
	
	email_sendAsPlainTextWithArray($values);
}

function email_sendAsPlainTextWithArray($values)
{
	$mail             = new PHPMailer();
	$mail->SetFrom($values['from_address'], $values['from_name']);
	$mail->Subject    = $values['subject'];
	$mail->Body       = $values['body'];
	
	
	
	foreach($values['recipients'] as $address){
		$mail->AddAddress($address);
	}
	
	$mail->Send();
}

function email_sendAsHTMLWithArray($values)
{
	$mail             = new PHPMailer();
	$mail->SetFrom($values['from_address'], $values['from_name']);
	$mail->Subject    = $values['subject'];
	
	//$mail->AltBody    = $altBody;
	$mail->MsgHTML($values['body']);
	
	
	foreach($values['recipients'] as $address){
		$mail->AddAddress($address);
	}
	
	$mail->Send();
}
?>