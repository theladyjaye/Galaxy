<?php
/**
 *    Galaxy - Core
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
 *    @package galaxy
 *    @subpackage security
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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
	private $additionalParameters;
	
	public function __construct($key=null, $secret=null)
	{
		$this->key    = $key    ? $key    : null;
		$this->secret = $secret ? $secret : null;
	}
	
	public function setAdditionalParameters($value)
	{
		$this->additionalParameters = $value;
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
		
		if(!empty($this->additionalParameters))
		{
			if(is_array($this->additionalParameters))
			{
				$base_string = array_merge($base_string, $this->additionalParameters);
				ksort($base_string);
			}
		}
		
		// we will be sending arrays in this, and http_build_query() builds the right thing for recursive arrays
		// but it encodes it wrong for our needs, which is why we are decoding it, and then rawurlencoding it afterwards
		$params = urldecode(http_build_query($base_string));
		
		$string       = strtoupper($this->method)."&".$this->absolute_url."&".$params;
		$string       = rawurlencode($string);
		
		$signature    = urlencode(base64_encode(hash_hmac('sha1', $string, $this->secret, true)));
		
		// there will not be any Query String Params at this time, so we will always go with an Authorization: header
		
		return <<<AUTH
Authorization: OAuth{$this->realm}, oauth_consumer_key="$this->key", oauth_token="", oauth_signature_method="$this->signature_method", oauth_signature="$signature", oauth_timestamp="$time", oauth_nonce="$nonce", oauth_version="$this->version"
AUTH;
	}
}
?>