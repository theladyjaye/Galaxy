<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/couchdb/CouchDB.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ApplicationDetail.php';
class Applications extends ViewController
{
	protected $requiresAuthorization  = true;
	
	protected function initialize()
	{
		echo 20;
	}
	
	public function javascript()
	{
		$this->jquery();
		$this->forms();
	}
	
	public function showApplications()
	{
		/*$mongodb  = Renegade::database(RenegadeConstants::kDatabaseMongoDB, RenegadeConstants::kDatabaseApplications);
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
		}*/
	}
}
?>