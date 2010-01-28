package galaxy.commands
{
	public class GalaxyCommand
	{
		public static const GALAXY_METHOD_GET    : String = "GET";
		public static const GALAXY_METHOD_POST   : String = "POST";
		public static const GALAXY_METHOD_PUT    : String = "PUT";
		public static const GALAXY_METHOD_DELETE : String = "DELETE";
		
		public var content     : *;
		public var contentType : String;
		public var endpoint    : String;
		public var method      : String;
		public var callback    : Function;
		
		public function GalaxyCommand()
		{
			prepareCommand();
		}
		
		protected function prepareCommand():void {}
	}
}