package galaxy.net
{
	import galaxy.commands.GalaxyCommand;
	import galaxy.models.GalaxyOptions;
	import galaxy.models.GalaxyAuthorization;
	import flash.net.URLRequest;
	import flash.net.URlRequestHeader;
	
	public class GalaxyOperation
	{
		public var command : GalaxyCommand;
		public var options : GalaxyOptions;
		public var result  : String;
		
		private var galaxyHost      : String = "api.galaxyfoundry.com";
		private var galaxyPort      : int    = 80;
		private var galaxyUserAgent : String = "GalaxyClientCore/1.0 (AS3)";
		private var galaxyScheme    : String = "glxy://";
		
		public function GalaxyOperation(command:GalaxyCommand, options:GalaxyOptions)
		{
			this.command = command;
			this.options = options;
		}
		
		public function main():void
		{
			var request : URLRequest = new URLRequest(this.absoluteUrl(true));
			var headers : Array      = new Array();
			
			request.userAgent = galaxyUserAgent;
			request.method    = command.method;
			
			if(options.authorization.authorizationType == GalaxyAuthorization.OAUTH)
			{
				headers.push(new URLRequestHeader('Authorization', ));
			}
			
			headers.push(new URLRequestHeader('Accept', options.applicationFormat));
			request.requestHeaders = headers;
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