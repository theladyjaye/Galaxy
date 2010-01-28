package galaxy.security.oauth
{
	import galaxy.security.IGalaxyAuthorization;
	
	public class GalaxySignatureOAuth implements IGalaxyAuthorization
	{
		public var method               : String
		public var key                  : String;
		public var secret               : String;
		public var realm                : String;
		public var absoluteUrl          : String;
		public var additionalParameters : *;
		
		private  signatureMethod        : String = "HMAC-SHA1";
		private  version                : String = "1.0";
		
		public function GalaxySignatureOAuth(key:String, secret:String)
		{
			this.key    = key;
			this.secret = secret;
		}
		
		public function authorizationSignature():String
		{
			var baseString : Vector.<String>  = new Vector.<String>();
			
			baseString.push(new GalaxyOAuthField("oauth_consumer_key", key));
			baseString.push(new GalaxyOAuthField("oauth_nonce", generateNonce()));
			baseString.push(new GalaxyOAuthField("oauth_signature_method", signatureMethod));
			baseString.push(new GalaxyOAuthField("oauth_timestamp", ""));
			baseString.push(new GalaxyOAuthField("oauth_token", ""));
			baseString.push(new GalaxyOAuthField("oauth_version", version));
			
			if(additionalParameters)
			{
				
			}
			
			baseString = baseString.sort(function(a:String b:String):Number
			{
				var value : Number = 0;
				
				if(a < b)
				{
					value = -1;
				}
				else if(a > b)
				{
					value = 1;
				}
				else if (a == b)
				{
					value = 0;
				}
				
				return value;
			})
			
			var signatureInput : String = method+"&"+absoluteUrl+"&"+buildQuery(baseString);
		}
		
		private function generateNonce():String
		{
			return "1234";
		}
		
		private function buildQuery():String
		{
			
		}
	}
	
	
}