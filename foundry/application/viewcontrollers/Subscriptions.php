<?php

require $_SERVER['DOCUMENT_ROOT'].'/application/functions/SecurityFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/forms/AMForm.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/validators/ApplicationIdValidator.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/SubscriptionDetail.php';

class Subscriptions extends ViewController
{
	protected $requiresAuthorization  = true;
	public $channel;
	public $subscriptions;
	public $application_id;
	protected function initialize()
	{
		$id                   = $_GET['id'];
		$this->application_id = Renegade::applicationIdForChannelId($id);
		
		$options              = array('default' => Renegade::databaseForId($this->application_id));
		$database             = Renegade::database(RenegadeConstants::kDatabaseMongoDB, null, $options);
		                      
		$channels             = $database->selectCollection(RenegadeConstants::kDatabaseChannels);
		$this->channel        = $channels->findOne(array('_id' => $id));
		
		if($this->channel)
		{
			$subscriptions  = $database->selectCollection(RenegadeConstants::kDatabaseSubscriptions);
			
			/*
				TODO index 'application' on subscriptions
			*/
			$this->subscriptions = $subscriptions->find(array('application' => array('$ne' => $this->application_id)));
		}
		else
		{
			Renegade::redirect('/applications');
		}
	}
	
	public function showSubscriptions()
	{
		$certificates = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
		if($this->subscriptions->count())
		{
			foreach($this->subscriptions as $subscription)
			{
				$permissions                 = $certificates->get($subscription['certificate']);
				$subscription['permissions'] = $permissions;
				echo new SubscriptionDetail($subscription);
			}
		}
		else
		{
			echo 'No Subscriptions';
		}
	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
}
?>