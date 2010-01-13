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
		
		if($this->isPostBack)
		{
			$this->processForm();
		}
		
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
	
	private function processForm()
	{
		$context = array(AMForm::kDataKey => $_POST);
		$form = AMForm::formWithContext($context);
		
		switch($form->context)
		{
			case 'Update':
				$this->processUpdate($form);
				break;
				
			case 'Delete':
				$this->processDelete($form);
				break;
		}
	}
	
	private function processUpdate(AMForm $form)
	{
		$read        = $form->inputRead   ? RenegadeConstants::kPermissionRead   : 0;
		$write       = $form->inputWrite  ? RenegadeConstants::kPermissionWrite  : 0;
		$delete      = $form->inputDelete ? RenegadeConstants::kPermissionDelete : 0;
		
		$permissions = $read|$write|$delete;
		
		if($permissions == 0)
		{
			$this->processDelete($form);
		}
		else
		{
			$options       = array('default' => Renegade::databaseForId($this->application_id));
			$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options);
			
			$data = $subscriptions->findOne(array('_id' => new MongoId($form->inputSubscription)));
			
			if($data)
			{
				$certificates = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
				$certificates->set($data['certificate'], $permissions);
			}
		}
	}
	
	private function processDelete(AMForm $form)
	{
		$options       = array('default' => Renegade::databaseForId($this->application_id));
		$subscriptions = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseSubscriptions, $options);
		$certificates  = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
		
		$data = $subscriptions->findOne(array('_id' => new MongoId($form->inputSubscription)));
		
		$remote_options  = array('default' => Renegade::databaseForId($data['application']));
		$remote_channels = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $remote_options);
		
		$subscriptions->remove(array('_id' => new MongoId($form->inputSubscription)));
		$remote_channels->remove(array('_id' => $data['channel']));
		$certificates->delete($data['certificate']);
	}
	
	
}
?>