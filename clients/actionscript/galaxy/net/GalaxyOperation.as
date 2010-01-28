package galaxy.net
{
	import galaxy.commands.GalaxyCommand;
	import galaxy.models.GalaxyOptions;
	import galaxy.models.GalaxyAuthorization;
	import galaxy.security.oauth.GalaxySignatureOAuth;
	import flash.net.URLRequest;
	import flash.net.URLRequestHeader;
	import flash.net.URLLoader;
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	
	public class GalaxyOperation
	{
		public var command : GalaxyCommand;
		public var options : GalaxyOptions;
		public var result  : String;
		
		private var galaxyHost      : String = "api.galaxyfoundry.com";
		private var galaxyPort      : int    = 80;
		private var galaxyUserAgent : String = "GalaxyClientCore/1.0 (AS3)";
		private var galaxyScheme    : String = "glxy://";
		private var loader          : URLLoader;
		
		public function GalaxyOperation(command:GalaxyCommand, options:GalaxyOptions)
		{
			this.command = command;
			this.options = options;
		}
		
		public function execute():void
		{
			var request : URLRequest = new URLRequest(this.absoluteUrl(true));
			var headers : Array      = new Array();
			
			request.userAgent = galaxyUserAgent;
			request.method    = command.method;
			
			if(options.authorization.authorizationType == GalaxyAuthorization.OAUTH)
			{
				var signature : GalaxySignatureOAuth = new GalaxySignatureOAuth(options.authorization.applicationKey, options.authorization.applicationSecret);
				signature.method      = command.method;
				signature.realm       = galaxyScheme+options.context;
				signature.absoluteUrl = this.absoluteUrl();
				
				
				if(command.method == GalaxyCommand.GALAXY_METHOD_GET || command.method == GalaxyCommand.GALAXY_METHOD_POST)
				{
					//[(GalaxySignatureOAuth *)authorization setAdditionalParameters:command.content];
				}
				
				headers.push(new URLRequestHeader('Authorization', signature.authorizationSignature()));
			}
			
			headers.push(new URLRequestHeader('Accept', options.applicationFormat));
			request.requestHeaders = headers;
			
			loader = new URLLoader();
			loader.addEventListener(Event.COMPLETE, operationDidComplete);
			loader.addEventListener(IOErrorEvent.IO_ERROR, operationDidFail);
			loader.load(request);
		}
		
		private function operationDidComplete(e:Event):void
		{
			trace(e.target.data);
			cleanup();
		}
		
		private function operationDidFail(e:IOErrorEvent):void
		{
			cleanup();
		}
		
		private function cleanup()
		{
			loader.removeEventListener(Event.COMPLETE, operationDidComplete);
			loader.removeEventListener(IOErrorEvent.IO_ERROR, operationDidFail);
		}
		
		private function absoluteUrl(shoudlIncludePort:Boolean=false)
		{
			var url:String = "http://"+galaxyHost;
			
			if(shoudlIncludePort)
			{
				url += ":"+galaxyPort;
			}
			
			url += "/"+command.endpoint;
			
			return url;
		}
	}
}