package constellation
{
	import galaxy.GalaxyApplication;
	import galaxy.models.GalaxyOptions;
	import constellation.commands.CNTopicList;
	import constellation.commands.CNMessages;
	
	public class Constellation extends GalaxyApplication
	{
		private var delegate:IConstellationDelegate;
		
		public function Constellation(delegate:IConstellationDelegate)
		{
			super();
			this.delegate = delegate;
		}
		
		public function forums():void
		{
			if(delegate.constellationShouldGetForums(this))
			{
				this.channels(didReceiveForums);
			}
		}
		
		public function topics(forum:String, page:int=1, limit:int=25):void
		{
			if(delegate.constellationShouldGetTopicsForForum(this, forum))
			{
				var command                 = new CNTopicList();
				var options : GalaxyOptions = this.defaultOptions;
				command.callback            = didReceiveTopics
				options.context             = forum;
				command.content             = {page:String(page), limit:String(limit)};
				
				execute(command, options);
			}
		}
		
		public function messages(topic:String, page:int=1, limit:int=25):void
		{
			if(delegate.constellationShouldGetMessagesForTopic(this, topic))
			{
				var command                 = new CNMessages();
				var options : GalaxyOptions = this.defaultOptions;
				command.callback            = didReceiveMessages
				options.context             = topic;
				command.content             = {page:String(page), limit:String(limit)};
				
				execute(command, options);
			}
		}
		
		private function didReceiveForums(data:String):void
		{
			trace(data);
		}
		
		private function didReceiveTopics(data:String):void
		{
			trace(data);
		}
		
		private function didReceiveMessages(data:String):void
		{
			trace(data);
		}
	}
}