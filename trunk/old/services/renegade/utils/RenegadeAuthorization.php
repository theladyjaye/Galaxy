<?php
class RenegadeAuthorization
{
	const kDefaultSignatureMethod    = 'HMAC-SHA1';
	const kDefaultVersion            = '1.0';
	
	private $key;
	private $secret;
	private $command;
	private $nonce;
	private $signature_method;
	private $version;
	
	public static function authorizationForCommandWithKeyAndSecret(RenegadeCommand $command, $key, $secret, $options=null)
	{
		$auth                    = new RenegadeAuthorization();
		$auth->key               = $key;
		$auth->secret            = $secret;
		$auth->command           = $command->descriptor();
		$auth->nonce             = $options['nonce'] ? $options['nonce'] : $auth->generate_nonce();
		$auth->signature_method  = $options['signature_method'] ? $options['signature_method'] : RenegadeAuthorization::kDefaultSignatureMethod;
		$auth->version           = $options['version'] ? $options['version'] : RenegadeAuthorization::kDefaultVersion;
		
		return $auth;
	}
	
	public function generate_nonce()
	{
		return md5(uniqid(mt_rand(), true));
	}
	
	public function setCookies()
	{
		
	}
	
	public function __toString()
	{
		$time                                  = time();
		$base_string                           = array(); 
		$base_string['oauth_consumer_key']     = $this->key;
		$base_string['oauth_nonce']            = $this->nonce;
		$base_string['oauth_signature_method'] = $this->signature_method;
		$base_string['oauth_timestamp']        = $time;
		$base_string['oauth_token']            = '';
		$base_string['oauth_version']          = $this->version;
		
		$string    = $this->command['verb']."&".$this->command['uri']."&".http_build_query($base_string);
		$string    = urlencode($string);
		
		$signature = urlencode(base64_encode(hash_hmac('sha1', $string, $this->secret, true)));
		
		//echo urlencode($signature);exit;
		return <<<AUTH
OAuth, oauth_consumer_key="$this->key", oauth_token="", oauth_signature_method="$this->signature_method", oauth_signature="$signature", oauth_timestamp="$time", oauth_nonce="$this->nonce", oauth_version="$this->version"
AUTH;
	}
}
?>