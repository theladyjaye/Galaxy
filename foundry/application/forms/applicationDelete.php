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
			$options_local = array('default'=>Renegade::databaseForId($form->inputId));
			$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options_local);
			$certificates  = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
			$applications  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
			$store         = Renegade::database(RenegadeConstants::kDatabaseMongoDB, null, $options_local);
			$data          = $subscriptions->find();
			
			// flush all the channels
			foreach($data as $subscription)
			{
				if($subscription['application'] != $form->inputId)
				{
					// we need to clear the channel from a remote application
					
					$options_remote  = array('default'=>Renegade::databaseForId($subscription['application']));
					$channels_remote = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options_remote);
					$channels_remote->remove(array('_id' => $subscription['channel']));
					
					/*
						TODO need to remember if whenyou subscribe to a channel if a channel gets written + a subscription to the subscribing applications
						info.  I forget...  If it does we need to delete the remote subscription too not just the channel.  I don't think it works tha way
						but I don't have that part fully written yet either.
						$subscriptions_remote = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscription, $options_remote);
					*/
					
				}
				
				//echo $subscription['certificate'];
				$certificates->delete($subscription['certificate']);
			}
			
			$applications->remove(array('_id' => $form->inputId));
			$store->drop();
			$certificates->delete($form->inputCertificate);
		}
	}
}

header('Location:/applications');
?>