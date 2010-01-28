package constellation.events
{
	import galaxy.events.GalaxyEvent;
	import flash.events.Event;
	
	public class ConstellationEvent extends GalaxyEvent
	{
		public static const COMPLETE_FORUMS   : String = 'complete_forums';
		public static const COMPLETE_TOPICS   : String = 'complete_topics';
		public static const COMPLETE_MESSAGES : String = 'complete_messages';
		
		public var data : String;
		
		public function ConstellationEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false)
		{
			super(type, bubbles, cancelable);
		}
		
		override public function clone():Event
		{
			var e : ConstellationEvent = new ConstellationEvent(type);
			e.data = data;
			
			return e;
		}
	}
}