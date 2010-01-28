package galaxy.events
{
	import flash.events.Event;
	
	public class GalaxyEvent extends Event
	{
		public static const COMPLETE : String = "complete";
		
		public function GalaxyEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false)
		{
			super(type, bubbles, cancelable);
		}
		
		override public function clone():Event
		{
			return new GalaxyEvent(type,bubbles,cancelable);
		}
	}
}