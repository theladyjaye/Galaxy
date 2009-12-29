<?php
class RenegadeAuthorization
{
	private $request;
	
	public function __construct(RenegadeRequest $request)
	{
		$this->request = $request;
	}
	
	public function verify()
	{
		static $result = null;
		
		if($result === null)
		{
			$db      = Application::database();
			
			$options = array('key'   => $this->request->authorization['oauth_consumer_key'],
			                 'limit' => 1);

			$rows = $db->view('applications/channel', $options);
			$secret = $rows[0]['value']['secret'];

			$time                                  = 
			$base_string                           = array(); 
			$base_string['oauth_consumer_key']     = $this->request->authorization['oauth_consumer_key'];
			$base_string['oauth_nonce']            = $this->request->authorization['oauth_nonce'];
			$base_string['oauth_signature_method'] = $this->request->authorization['oauth_signature_method'];
			$base_string['oauth_timestamp']        = $this->request->authorization['oauth_timestamp'];
			$base_string['oauth_token']            = '';
			$base_string['oauth_version']          = $this->request->authorization['oauth_version'];



			$string    = $_SERVER['REQUEST_METHOD']."&http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&".http_build_query($base_string);
			$string    = urlencode($string);

			$signature = base64_encode(hash_hmac('sha1', $string, $secret, true));

			$sig1  = base64_decode(urldecode($this->request->authorization['oauth_signature']));
			$sig2  = base64_decode($signature);

			$result = rawurlencode($sig1) == rawurlencode($sig2);
		}
		
		return $result;
	}
}
?>