<?php
$base = dirname(__FILE__);
require $base.'/utils/RenegadeAuthorization.php';
require $base.'/net/RenegadeConnection.php';
require $base.'/net/RenegadeResponse.php';
require $base.'/commands/RenegadeCommand.php';
require $base.'/commands/PutStory.php';

class Renegade
{	
	private $key;
	private $secret;
	private $format;
	
	public function __construct($key, $secret, $format='json')
	{
		$this->key    = $key;
		$this->secret = $secret;
		$this->format = $format;
	}
	
	public function put_story($story)
	{
		$story['consumer'] = $this->key;
		
		$story             = json_encode($story);
		$connection        = new RenegadeConnection();
		$response          = $connection->execute(new PutStory($story), $this->key, $this->secret);
		
		return $response->result;
	}
	
	private function signature()
	{
		static $signature = null;
		
		if(!$signature){
			$signature = hash_hmac('sha1', $this->key, $this->secret);
		}
		
		return $signature;
	}
}
?>