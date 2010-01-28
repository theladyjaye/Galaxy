package galaxy.models
{
	public class GalaxyAuthorization
	{
		public static const OAUTH    : int = 1;
		
		public var authorizationType : int;
		public var applicationKey    : String;
		public var applicationSecret : String;
		
		public function GalaxyAuthorization()
		{
			authorizationType = GalaxyAuthorization.OAUTH;
		}
	}
}