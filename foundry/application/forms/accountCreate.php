<?php
/**
 *    Galaxy - Foundry
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package foundry
 *    @subpackage forms
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/models/User.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMEmailValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMMatchValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMInputValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/UniqueUsernameValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/UniqueEmailValidator.php';

require $_SERVER['DOCUMENT_ROOT'].'/application/mail/MailEnvironment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/mail/AuthorizeAccountMail.php';


if(count($_POST))
{
	$context = array(AMForm::kDataKey => $_POST);
	$form    = AMForm::formWithContext($context);

	// we want more nuanced errors when creating an account, so we have more validators.
	$form->addValidator(new AMInputValidator('inputName', true, 4, null, 'Screen Name must be at least 4 characters long'));
	$form->addValidator(new AMPatternValidator('inputName', true, '/^\w+$/', 'Screen Name may only container letters, numbers or _'));
	$form->addValidator(new UniqueUsernameValidator('inputName', true, 'Username is not unique, please choose an alternative name'));
	$form->addValidator(new AMEmailValidator('inputEmail', true, 'Please provide a valid e-mail address'));
	$form->addValidator(new UniqueEmailValidator('inputEmail', true, 'Email address is currently in use'));
	$form->addValidator(new AMMatchValidator('inputPassword', 'inputPasswordVerify', true, 'Password must match'));
	$form->addValidator(new AMInputValidator('inputPassword', true, 4, null, 'Password must be at least 4 characters long'));
	$form->addValidator(new AMPatternValidator('inputPassword', true, '/^[\S]+$/', 'Password cannot contain spaces'));

	$form->validate();

	if($form->isValid)
	{
	
		$user           = new User();
		$user->email    = $form->inputEmail;
		$user->password = $form->inputPassword;
		$user->id       = $form->inputName;
		$user->verified = false;
		
		$id                 = strtolower($form->inputName);
		$db                 = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseUsers);
		
		$verification_token = renegade_generate_token();
		User::generateVerificationForUserWithKey($user, $verification_token);

		// by the time we are here, we can set the record
		// but just in case we run msetnx to be sure we are not overwritting someone elses account.
		$db->msetnx($user->array);
		
		$email = new AuthorizeAccountMail(array(strtolower($form->inputEmail)), $verification_token);
		$email->send();
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