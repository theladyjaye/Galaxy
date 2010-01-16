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
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ApplicationDetail.php';
class Applications extends ViewController
{
	protected $requiresAuthorization  = true;
	
	protected function initialize()
	{
	
	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
	
	public function showApplications()
	{
		$mongodb  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
		$redis    = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseCertificates);
		$session  = Renegade::session();
		$response = $mongodb->find(array('owner'=>$session->user));
		
		if($response->count())
		{
			foreach($response as $id => $application)
			{
				// mget might be better here...
				$certificate = json_decode($redis->get($application['certificate']), true);
				
				$application['api_key']           = $certificate['key'];
				$application['api_secret']        = $certificate['secret'];
				$application['permission_read']   = $application['defaultPermissions'] & RenegadeConstants::kPermissionRead   ? 'Yes' : 'No'; 
				$application['permission_write']  = $application['defaultPermissions'] & RenegadeConstants::kPermissionWrite  ? 'Yes' : 'No'; 
				$application['permission_delete'] = $application['defaultPermissions'] & RenegadeConstants::kPermissionDelete ? 'Yes' : 'No'; 
				
				echo new ApplicationDetail($application);
				
			}
		}
		else
		{
			echo 'No Applications';
		}
	}
}
?>