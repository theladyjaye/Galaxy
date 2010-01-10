<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/services/facebook/Facebook.php';

class SettingsFacebook
{
	private $isAuthorized;
	private $authorized_user;
	function __construct(User &$user) 
	{
		
		if(!$user->facebook_user)
		{
			$facebook      = new Facebook(FacebookConfig::kConsumerKey, FacebookConfig::kConsumerSecret);
			$facebook_user = $facebook->get_loggedin_user();
			
			if($facebook_user)
			{
				$hasExtendedPermission = $facebook->api_client->call_method('facebook.users_hasAppPermission',array('ext_perm' => 'status_update','uid' => $facebook_user));
				if($hasExtendedPermission)
				{
					$this->isAuthorized    = true;
					$user->facebook_user   = $facebook_user;
					$user->save();
					$this->authorized_user = $user->facebook_user;
				}
			}
		}
		else
		{
			$this->isAuthorized    = true;
			$this->authorized_user = $user->facebook_user;
		}
	}
	
	public function __toString()
	{

		
		if($this->isAuthorized)
		{
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/SettingsFacebookAuthorized.html');
		}
		else
		{
		
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/SettingsFacebook.html', $dictionary);
		}
	}
}
?>