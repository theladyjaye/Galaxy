<?php
/*
	TODO 
	1. Make sure the channel is not part of the subscribing application
	2. Make sure the user is the owner of the application we want to add the subscribed channel too
	3. Get the default permissions for the application 
		- This needs to be better thought out form a UI perspective I'm thinking something like:
			A.The user types in the channel name
			B.Perform and AJAX query to get the channels permissions
			C.If the channel has no default permissions (0) inform the user this channel is private.
			  If the channel has default permisisons( > 1) and they are not Read+Write+Delete then ask the user if they would
			  Like to request extended permissions from the application owner for this channel.
				I.Send e-mail to channel owner with what permissions are requested
				II. Include URL for the owner to manage the request
			D.Submit the subscription request.  Grant the request the default channel permissions until the 
			  application owner grants further permissions.
*/

require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Subscription.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/Channel.php';

if(count($_POST))
{
	$session = Renegade::session();
	
	if(strlen($session->user) > 1)
	{
		$context = array(AMForm::kDataKey => $_POST);
		$form    = AMForm::formWithContext($context);
		if($form->isValid)
		{
			// first, does the user own this application?
			$db_applications  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
			$application      = $db_applications->findOne(array('_id' => $form->inputApplicationId, 'owner' => $session->user));
			
			if($application)
			{
				// Next, make sure the channel they are subscribing too is not one of the channels in the application already
				$options_channels = array('default' => Renegade::databaseForId($form->inputApplicationId));
				$db_channels      = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options_channels);
				$existing_channel = $db_channels->findOne(array('_id' => $form->inputId));
				
				// Does the user already have this channel in their application?
				if($existing_channel)
				{
					echo 'You already have this channel';
					//Renegade::redirect('/applications/'.$form->inputApplicationId.'./channels');
				}
				// the user does NOT have this channel yet, so lets subscribe to it.
				else
				{
					$remote_application = Renegade::applicationIdForChannelId($form->inputId);
					$db_remote_options  = array('default' => Renegade::databaseForId($remote_application));
					$db_remote_channels = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $db_remote_options);
					$remote_channel     = $db_remote_channels->findOne(array('_id' => $form->inputId));
					
					// Is channel they want is real?
					if($remote_channel)
					{
						// is the channel private (no permissions)?
						if($remote_channel['defaultPermissions'] == 0)
						{
							echo 'channel is private';
							//Renegade::redirect('/applications/'.$form->inputApplicationId.'./channels');
						}
						// The channel is not private we can subscribe
						else
						{
							// is subscribing to a subscription channel in another application even possible?
							// I dont think so, since you would need the channel id anyway, which would point you to 
							// the origin application.
							
							/*
								TODO 
								We need to add a subscription to the remote subscriptions db for the remote collection
								We need to add the certificate for this channel
								We need to add the channel to the local application's channels
								Send an e-mail requesting extended permissions here if requested
							*/
							
							// we are giving the fully qualified channel id here
							// so we will not need to set the application, it will be done for us
							$channel = new Channel($remote_channel['_id']);
							$channel->setCertificate($application['certificate']);
							$channel->setLabel($remote_channel['label']);
							$channel->setDescription($remote_channel['description']);
							$channel->setDefaultPermissions($remote_channel['defaultPermissions']);
							
							$certificate  = $channel->generate_certificate($remote_channel['defaultPermissions']);
							$metadata     = $channel->generate_metadata();
							
							$metadata['requests'] = $remote_channel['requests'];
						
							$subscription = new Subscription();
							$subscription->setCertificate($certificate['key']);
							$subscription->setApplication($form->inputApplicationId);
							$subscription->setChannel($metadata['_id']);
							$subscription->setMaster(false);
							
							$db_remote_options       = array('default' => Renegade::databaseForId($remote_application));
							$db_remote_subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $db_remote_options);
							$certificates            = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
							
							$db_remote_subscriptions->insert($subscription->toArray());
							$db_channels->insert($metadata);
							$certificates->set($certificate['key'], $certificate['value']);
							
							
							// All Done
							Renegade::redirect('/applications/'.$form->inputApplicationId.'/channels');
						}
						
					}
					// Channel Not Found
					else
					{
						echo 'channel not found';
						//Renegade::redirect('/applications/'.$form->inputApplicationId.'./channels');
					}
				}
			}
		}
	}
}
Renegade::redirect('/');

?>