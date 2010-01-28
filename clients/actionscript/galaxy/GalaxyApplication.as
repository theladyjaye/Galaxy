package galaxy
{
	import flash.events.EventDispatcher;
	import galaxy.commands.GalaxyCommand;
	import galaxy.commands.GalaxyChannels;
	import galaxy.net.GalaxyOperation;
	import galaxy.models.GalaxyOptions;
	
	
	public class GalaxyApplication extends EventDispatcher
	{
		private var _defaultOptions : GalaxyOptions;
		
		public function GalaxyApplication()
		{
			_defaultOptions = new GalaxyOptions();
		}
		
		public function channels(callback:Function):void
		{
			var command : GalaxyChannels  = new GalaxyChannels();
			command.callback = callback;
			execute(command);
		}
		
		public function execute(command:GalaxyCommand, options:GalaxyOptions=null):void
		{
			options = options ? options : defaultOptions;
			var operation : GalaxyOperation = new GalaxyOperation(command, options);
			operation.callback = operationDidFinish;
			operation.execute();
		}
		
		public function get defaultOptions():GalaxyOptions
		{
			var options : GalaxyOptions             = new GalaxyOptions();
			options.context                         = new String(_defaultOptions.context);
			options.applicationFormat               = new String(_defaultOptions.applicationFormat);
			options.authorization.applicationKey    = new String(_defaultOptions.authorization.applicationKey);
			options.authorization.applicationSecret = new String(_defaultOptions.authorization.applicationSecret);
			options.authorization.authorizationType = _defaultOptions.authorization.authorizationType;
			
			return options;
		}
		
		protected function operationDidFinish(operation:GalaxyOperation):void
		{
			operation.command.callback(operation.result);
		}
		
		public function set applicationId(value:String):void
		{
			_defaultOptions.context = value;
		}
		
		public function set applicationKey(value:String):void
		{
			_defaultOptions.authorization.applicationKey = value;
		}
		
		public function set applicationSecret(value:String):void
		{
			_defaultOptions.authorization.applicationSecret = value;
		}
	}
}