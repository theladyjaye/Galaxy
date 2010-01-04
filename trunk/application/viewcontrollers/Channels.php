<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetail.php';
class Channels extends ViewController
{
	protected $requiresAuthorization  = true;
	public $application;

	
	protected function initialize()
	{
		
		$db          = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
		$application = $db->findOne(array('_id'=>$_GET['id']));
		
		if($application['owner'] != $this->session->user)
		{
			header('Location: /applications');
			exit;
		}
		
		if($application['error'])
		{
			header('Location: /applications');
			exit;
		}
		
		$this->application = $application;
	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
	
	public function defaultPermissionRead()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionRead) ? 'checked' : '';
	}
	
	public function defaultPermissionWrite()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionWrite) ? 'checked' : '';
	}
	
	public function defaultPermissionDelete()
	{
		echo ($this->application['defaultPermissions'] & RenegadeConstants::kPermissionDelete) ? 'checked' : '';
	}
	
	public function showChannels()
	{
		$options     = array('default'=>Renegade::databaseForId($_GET['id']));
		$db          = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseChannels, $options);
		$channels    = $db->find();
		if($channels->count())
		{
			foreach($channels as $channel)
			{
				$channel['permission_read']   = $channel['defaultPermissions'] & RenegadeConstants::kPermissionRead   ? 'Yes' : 'No'; 
				$channel['permission_write']  = $channel['defaultPermissions'] & RenegadeConstants::kPermissionWrite  ? 'Yes' : 'No'; 
				$channel['permission_delete'] = $channel['defaultPermissions'] & RenegadeConstants::kPermissionDelete ? 'Yes' : 'No';
				
				if($channel['application'] != $this->application['_id'])
				{
					echo new ChannelDetail($channel, ChannelDetail::kContextSubscription);
				}
				else
				{
					echo new ChannelDetail($channel);
				}
				
			}
		}
		else
		{
			echo 'No Channels';
		}
	}
}
?>