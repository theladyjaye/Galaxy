<?php
class RenegadeRequest
{
	private $_headers;
	private $_isSigned;
	private $_isAuthorized;
	private $_realm;
	private $_authorization;
	
	public function __construct()
	{
		$this->_headers  = getallheaders();
		$this->_isSigned = $this->requestIsSigned();
		
		if($this->_isSigned)
		{
			$this->_authorization = array();
			$this->processAuthorizationHeaders();
			
			$auth = new RenegadeAuthorization($this);
			$this->_isAuthorized = $auth->verify();
		}
	}
	
	/*
	OAuth, 
	oauth_consumer_key="206c0862ff965f861c87ee2fa37e7467", 
	oauth_token="", 
	oauth_signature_method="HMAC-SHA1", 
	oauth_signature="zYt3unBKlAMkrO3P51M+eGaY+B8=", 
	oauth_timestamp="1248656351", 
	oauth_nonce="bdce270f8106bb387801ce469ab5d083", 
	oauth_version="1.0"
	*/
	// http://code.google.com/p/oauth-php/source/browse/trunk/library/OAuthRequest.php
	// no need to reinvent the wheel
	private function processAuthorizationHeaders()
	{
		if (isset($this->headers['Authorization']))
		{
			$auth = trim($this->headers['Authorization']);
			if (strncasecmp($auth, 'OAuth', 4) == 0)
			{
				$vs = explode(',', substr($auth, 6));
				
				foreach ($vs as $v)
				{
					if (strpos($v, '='))
					{
						$v = trim($v);
						list($name,$value) = explode('=', $v, 2);
						
						if (!empty($value) && $value{0} == '"' && substr($value, -1) == '"'){
							$value = substr(substr($value, 1), 0, -1);
						}
						
						if (strcasecmp($name, 'realm') == 0)
						{
							$this->realm = $value;
						}
						else
						{
							$this->_authorization[$name] = $value;
						}
					}
				}
			}
		}
	}
	
	private function requestIsSigned()
	{
		$status  = false;
		if (isset($this->headers['Authorization']) && strpos($this->headers['Authorization'], 'oauth_signature') !== false)
		{
			$status = true;
		}
		
		return $status;
	}
	
	public function __get($value)
	{
		switch($value)
		{
			case 'headers':
				return $this->_headers;
				break;
			
			case 'isSigned':
				return $this->_isSigned;
				break;
			
			case 'isAuthorized':
				return $this->_isAuthorized;
				break;
			
			case 'realm':
				return $this->_realm;
				break;
			
			case 'authorization':
				return $this->_authorization;
				break;
		}
	}
}
?>