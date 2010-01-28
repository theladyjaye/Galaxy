package galaxy.models
{
	public class GalaxyOptions
	{
		public var applicationFormat : String;
		public var context           : String;
		public var authorization     : GalaxyAuthorization;
		
		public function GalaxyOptions()
		{
			applicationFormat = "application/json";
			authorization     = new GalaxyAuthorization();
		}
	}
}