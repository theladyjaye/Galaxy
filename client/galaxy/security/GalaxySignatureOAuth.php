<?php
class GalaxySignatureOAuth
{
	private $key;
	private $secret;
	private $signature_method = 'HMAC-SHA1';
	private $version          = '1.0';
	private $command;
	private $method;
	private $absolute_url;
	private $realm;
	
	public function __construct($key=null, $secret=null)
	{
		$this->key    = $key    ? $key    : null;
		$this->secret = $secret ? $secret : null;
	}
	
	public function setKey($value)
	{
		$this->key = $value;
	}
	
	public function setRealm($value)
	{
		$this->realm = ' realm="'.$value.'"';
	}
	
	public function setSecret($value)
	{
		$this->secret = $value;
	}
	
	public function setAbsoluteUrl($value)
	{
		$this->absolute_url = $value;
	}
	
	public function setMethod($value)
	{
		$this->method = $value;
	}
	
	private function generate_nonce()
	{
		return uniqid('');
	}
	
	public function __toString()
	{
		$nonce  = $this->generate_nonce();
		
		// right now this is not handling any additional POST or QS arguments.

		$time                                  = time();
		$base_string                           = array(); 
		$base_string['oauth_consumer_key']     = $this->key;
		$base_string['oauth_nonce']            = $nonce;
		$base_string['oauth_signature_method'] = $this->signature_method;
		$base_string['oauth_timestamp']        = $time;
		$base_string['oauth_token']            = '';
		$base_string['oauth_version']          = $this->version;
		
		$string       = strtoupper($this->method)."&".$this->absolute_url."&".http_build_query($base_string);
		$string       = urlencode($string);
		
		$signature    = urlencode(base64_encode(hash_hmac('sha1', $string, $this->secret, true)));
		
		// there will not be any Query String Params at this time, so we will always go with an Authorization: header
		
		return <<<AUTH
Authorization: OAuth{$this->realm}, oauth_consumer_key="$this->key", oauth_token="", oauth_signature_method="$this->signature_method", oauth_signature="$signature", oauth_timestamp="$time", oauth_nonce="$nonce", oauth_version="$this->version"
AUTH;
	}
}
?>