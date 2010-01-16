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
 *    @subpackage viewcontrollers
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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
				/*
					TODO Need a way to include the channels permissions in the channel view
					just to let people know what they are allowed to do to their respective channels.
					below are just the default permissions, they don't reflect the actual permissions for this user.
					this will also be important when the application owner manages subscriptions.
				*/
				$channel['permission_read']     = $channel['defaultPermissions'] & RenegadeConstants::kPermissionRead   ? 'Yes' : 'No'; 
				$channel['permission_write']    = $channel['defaultPermissions'] & RenegadeConstants::kPermissionWrite  ? 'Yes' : 'No'; 
				$channel['permission_delete']   = $channel['defaultPermissions'] & RenegadeConstants::kPermissionDelete ? 'Yes' : 'No';
				$channel['current_application'] = $this->application['_id'];
				
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