<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/services/twitter/Twitter.php';
class SettingsTwitter
{
	private $authorization_url;
	private $isAuthorized;
	function __construct(User &$user) 
	{
		if($user->twitter_access_token && $user->twitter_access_token_secret)
		{
			$this->isAuthorized = true;
			//$request = new TwitterRequest(Twitter::kConsumerKey, Twitter::kConsumerSecret, $user->twitter_access_token, $user->twitter_access_token_secret);
			//$content = $request->request('https://twitter.com/statuses/update.xml', array('status' => 'Test OAuth update with stored keys from the DB over HTTPS'), 'POST');
		}
		else
		{
			$authorization = new TwitterAuthorization();
			
			if($authorization->state == 'start')
			{
				$request = new TwitterRequest(Twitter::kConsumerKey, Twitter::kConsumerSecret);
				$tokens  = $request->requestToken();
				$authorization->setRequestTokens($tokens);
				$this->authorization_url = $authorization->url();
			}
			else
			{
				$user->twitter_access_token        = $authorization->oauth_access_token;
				$user->twitter_access_token_secret = $authorization->oauth_access_token_secret;
				$user->save();
				$this->isAuthorized = true;
				unset($_SESSION[Twitter::kAuthorizationSessionKey]);
			}
		}
	}
	
	public function __toString()
	{
		if($this->isAuthorized)
		{
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/SettingsTwitterAuthorized.html');
		}
		else
		{
			$dictionary = array("url" => $this->authorization_url);
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/SettingsTwitter.html', $dictionary);
		}
		
		
	}
}
?>