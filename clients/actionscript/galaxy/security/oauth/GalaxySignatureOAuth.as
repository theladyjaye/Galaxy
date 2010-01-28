package galaxy.security.oauth
{
	import galaxy.security.IGalaxyAuthorization;
	import galaxy.security.oauth.GalaxyOAuthField;
	
	import com.hurlant.crypto.Crypto;
	import com.hurlant.crypto.hash.HMAC;
	import com.hurlant.util.Base64;
	import flash.utils.ByteArray;
	
	public class GalaxySignatureOAuth implements IGalaxyAuthorization
	{
		public var method                   : String
		public var key                      : String;
		public var secret                   : String;
		public var realm                    : String;
		public var absoluteUrl              : String;
		public var additionalParameters     : *;
		
		private  var signatureMethod        : String = "HMAC-SHA1";
		private  var version                : String = "1.0";
		
		public function GalaxySignatureOAuth(key:String, secret:String)
		{
			this.key    = key;
			this.secret = secret;
		}
		
		public function authorizationSignature():String
		{
			var time:int = new Date().getTime()/1000;
			var nonce : String = generateNonce();
			var baseString : Vector.<GalaxyOAuthField>  = new Vector.<GalaxyOAuthField>();
			
			baseString.push(new GalaxyOAuthField("oauth_consumer_key", key));
			baseString.push(new GalaxyOAuthField("oauth_nonce", nonce));
			baseString.push(new GalaxyOAuthField("oauth_signature_method", signatureMethod));
			baseString.push(new GalaxyOAuthField("oauth_timestamp", time.toString()));
			baseString.push(new GalaxyOAuthField("oauth_token", ""));
			baseString.push(new GalaxyOAuthField("oauth_version", version));
			
			if(additionalParameters)
			{
				/*
					TODO Merge Additional GET or POST params into the vector
				*/
			}
			
			baseString = baseString.sort(function(a:GalaxyOAuthField, b:GalaxyOAuthField):Number
			{
				var value : Number = 0;
				
				if(a.key < b.key)
				{
					value = -1;
				}
				else if(a.key > b.key)
				{
					value = 1;
				}
				else if (a.key == b.key)
				{
					value = 0;
				}
				
				return value;
			})
			
			var signature      : String;
			var signatureInput : String = encodeURIComponent(method+"&"+absoluteUrl+"&"+buildQuery(baseString));
			
			var secretBytes    : ByteArray = new ByteArray();
			var signatureBytes : ByteArray = new ByteArray();
			
			signatureBytes.writeUTFBytes(signatureInput);
			signatureBytes.position = 0;
			
			secretBytes.writeUTFBytes(secret);
			secretBytes.position = 0;
			
			var hmac:HMAC        = Crypto.getHMAC("sha1");
			var result:ByteArray = hmac.compute(secretBytes, signatureBytes);
			signature = encodeURIComponent(Base64.encodeByteArray(result));
			
			return 'OAuth realm="'+realm+'", oauth_consumer_key="'+key+'", oauth_token="", oauth_signature_method="'+signatureMethod+'", oauth_signature="'+signature+'", oauth_timestamp="'+time.toString()+'", oauth_nonce="'+nonce+'", oauth_version="'+version+'"';
		}
		
		private function generateNonce():String
		{
			// taken from : http://opensource.adobe.com/svn/opensource/flex/sdk/trunk/frameworks/projects/framework/src/mx/utils/UIDUtil.as
			var ALPHA_CHAR_CODES:Array = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 65, 66, 67, 68, 69, 70];
			var uid:Array = new Array(36);
			var index:int = 0;

			var i:int;
			var j:int;

			for (i = 0; i < 8; i++)
			{
				uid[index++] = ALPHA_CHAR_CODES[Math.floor(Math.random() *  16)];
			}

			for (i = 0; i < 3; i++)
			{
				uid[index++] = 45; // charCode for "-"

				for (j = 0; j < 4; j++)
				{
					uid[index++] = ALPHA_CHAR_CODES[Math.floor(Math.random() *  16)];
				}
			}

			uid[index++] = 45; // charCode for "-"

			var time:Number = new Date().getTime();
			// Note: time is the number of milliseconds since 1970,
			// which is currently more than one trillion.
			// We use the low 8 hex digits of this number in the UID.
			// Just in case the system clock has been reset to
			// Jan 1-4, 1970 (in which case this number could have only
			// 1-7 hex digits), we pad on the left with 7 zeros
			// before taking the low digits.
			var timeString:String = ("0000000" + time.toString(16).toUpperCase()).substr(-8);

			for (i = 0; i < 8; i++)
			{
				uid[index++] = timeString.charCodeAt(i);
			}

			for (i = 0; i < 4; i++)
			{
				uid[index++] = ALPHA_CHAR_CODES[Math.floor(Math.random() *  16)];
			}

			return String.fromCharCode.apply(null, uid);
		}
		
		
		private function buildQuery(values:Vector.<GalaxyOAuthField>):String
		{
			var parts : Array = new Array();
			for each(var field : GalaxyOAuthField in values)
			{
				parts.push(encodeURIComponent(field.key)+"="+encodeURIComponent(field.value));
			}
			
			return parts.join('&');
		}
	}
	
	
}