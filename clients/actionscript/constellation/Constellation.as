package constellation
{
	import galaxy.GalaxyApplication;
	import galaxy.models.GalaxyOptions;
	import galaxy.serialization.JSONEncoder;
	import constellation.commands.CNTopicList;
	import constellation.commands.CNMessages;
	import constellation.commands.CNMessageNew;
	import constellation.commands.CNMessageUpdate;
	import constellation.events.ConstellationEvent;
	import constellation.models.CNMessage;
	import constellation.models.CNAuthor;
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
		
		public function message_new(message:CNMessage):void
		{
			if(delegate.constellationShouldCreateMessage(this, message))
			{
				var command                 = new CNMessageNew();
				var options : GalaxyOptions = this.defaultOptions;
				var encoder : JSONEncoder   = new JSONEncoder(message);
				
				command.content             = encoder.getString();
				command.contentType         = 'application/json';
				
				command.callback            = didUpdateMessage
				options.context             = message.context;
				
				execute(command, options);
			}
		}
		
		public function message_update(message:CNMessage):void
		{
			if(delegate.constellationShouldCreateMessage(this, message))
			{
				var command                 = new CNMessageUpdate();
				var options : GalaxyOptions = this.defaultOptions;
				
				command.content             = message;
				
				command.callback            = didSendMessage
				options.context             = message.context;
				
				execute(command, options);
			}
		}
		
		private function didReceiveForums(data:String):void
		{
			var e:ConstellationEvent = new ConstellationEvent(ConstellationEvent.COMPLETE_FORUMS);
			e.data = data;
			dispatchEvent(e);
		}
		
		private function didReceiveTopics(data:String):void
		{
			var e:ConstellationEvent = new ConstellationEvent(ConstellationEvent.COMPLETE_TOPICS);
			e.data = data;
			dispatchEvent(e);
		}
		
		private function didReceiveMessages(data:String):void
		{
			var e:ConstellationEvent = new ConstellationEvent(ConstellationEvent.COMPLETE_MESSAGES);
			e.data = data;
			dispatchEvent(e);
		}
		
		private function didUpdateMessage(data:String):void
		{
			trace(data);
			/*var e:ConstellationEvent = new ConstellationEvent(ConstellationEvent.COMPLETE_MESSAGES);
			e.data = data;
			dispatchEvent(e);*/
		}
		
		private function didSendMessage(data:String):void
		{
			trace(data);
			/*var e:ConstellationEvent = new ConstellationEvent(ConstellationEvent.COMPLETE_MESSAGES);
			e.data = data;
			dispatchEvent(e);*/
		}
	}
}