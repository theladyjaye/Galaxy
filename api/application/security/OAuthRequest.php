<?php
class OAuthRequest
{
	public $oauth_consumer_key;
	public $oauth_nonce;
	public $oauth_signature_method;
	public $oauth_signature;
	public $oauth_timestamp;
	public $oauth_token;
	public $oauth_version;
	public $realm;
	
	public function __construct($signature)
	{
		$signature = substr($signature, strpos($signature, ' ')+1);
		$parts     = explode(',', $signature);
		array_map(array($this,'process_key_value_pair'), $parts);
	}
	
	// key="value"
	private function process_key_value_pair($string)
	{
		$string            = trim($string);
		list($key, $value) = explode('=', $string);
		$this->{$key}      = substr($value, 1, -1);
	}
}
?>