package galaxy
{
	import galaxy.commands.GalaxyCommand;
	import galaxy.commands.GalaxyChannels;
	import galaxy.net.GalaxyOperation;
	import galaxy.models.GalaxyOptions;
	
	
	public class GalaxyApplication
	{
		protected var defaultOptions : GalaxyOptions;
		
		public function GalaxyApplication()
		{
			defaultOptions = new GalaxyOptions();
		}
		
		public function channels():void
		{
			var command : GalaxyChannels  = new GalaxyChannels();
			execute(command);
		}
		
		public function execute(command:GalaxyCommand, options:GalaxyOptions=null):void
		{
			options = options ? options : defaultOptions;
			var operation : GalaxyOperation = new GalaxyOperation(command, options);
			operation.execute();
		}
		
		public function set applicationId(value:String):void
		{
			defaultOptions.context = value;
		}
		
		public function set applicationKey(value:String):void
		{
			defaultOptions.authorization.applicationKey = value;
		}
		
		public function set applicationSecret(value:String):void
		{
			defaultOptions.authorization.applicationSecret = value;
		}
	}
}