<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/validators/AMPatternValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ChannelIdValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';

function form_prepare(&$item, $key)
{
	$item = trim($item);
	$item = strtolower($item);
}

$session = Renegade::session();

if(strlen($session->user) > 0 && count($_POST))
{
	
	array_walk($_POST, 'form_prepare');
		
	$context = array(AMForm::kDataKey => $_POST);
	$form    = AMForm::formWithContext($context);
	
	$form->addValidator(new ChannelIdValidator('inputChannelId', true, 'Invalid channel id'));
	$form->addValidator(new ApplicationIdValidator('inputApplicationId', true, 'Invalid application id'));
	
	if($form->isValid)
	{
		$db            = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
		$application   = $db->findOne(array('_id' => $form->inputApplicationId));
		
		if($application['owner'] == $session->user)
		{
			$options       = array('default' => Renegade::databaseForId($form->inputApplicationId));
		
			$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options);
			$redis         = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
		
			$master = $subscriptions->findOne(array('channel' => $form->inputChannelId, 'master'=> true));
		
			// are we the master channel? 
			// if so we need to clean out all subscriptions and channels in all applications
			// if not we just need to remove the subscription reference, and the channel reference
			// within the current applications
			if($master)
			{
				$data   = $subscriptions->find(array('channel' => $form->inputChannelId));
		
				foreach($data as $subscription)
				{
					$options  = array('default' => Renegade::databaseForId($subscription['application']));
					$channels = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options);
			
					$channels->remove(array('_id' => $subscription['channel']));
					$subscriptions->remove(array('_id' => $subscription['_id']));
					$redis->delete($subscription['certificate']);
				}
			}
			else
			{
				// we are deleting a subscription only
				$options_channels      = array('default' => Renegade::databaseForId($form->inputApplicationId));
				$options_subscriptions = array('default' => null);
				
				$channels = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options_channels);
				$data     = $channels->findOne(array('_id' => $form->inputChannelId));
				
				$options_subscriptions['default'] = Renegade::databaseForId($data['application']);
				$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options_subscriptions);

				$record        = $subscriptions->findOne(array('application' => $form->inputApplicationId, 'channel'=> $data['_id']));
				
				$subscriptions->remove(array('_id' => $record['_id']));
				$channels->remove(array('_id' => $form->inputChannelId));
				$redis->delete($record['certificate']);
			}
			
			header('Location:/applications/'.$form->inputApplicationId.'/channels');
			exit;
		}
		else
		{
			header('Location:/applications');
			exit;
		}
	}
}

header('Location:/applications');
exit;
?>