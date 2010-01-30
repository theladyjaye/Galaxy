package
{
	
	import flash.events.MouseEvent;
	import flash.display.MovieClip;
	import constellation.Constellation;
	import constellation.IConstellationDelegate;
	import constellation.events.ConstellationEvent;
	import com.adobe.serialization.json.JSONDecoder;
	import sample.views.Forum;
	import sample.views.Topic;
	import sample.views.Message;
	
	public class GalaxyTest extends MovieClip implements IConstellationDelegate
	{
		[Public]
		public var forum : Constellation;
		
		[Private]
		public var currentTopic : String;
		
		[Stage]
		/*
		public var viewContainer : MovieClip;
		pubiic var btn_forums    : MovieClip;
		*/
		
		public function GalaxyTest()
		{
			forum                   = new Constellation(this);
			forum.applicationId     = "com.galaxy.community";
			forum.applicationKey    = "849b35ec4988daa0dc5e77a0b30e8174";
			forum.applicationSecret = "b86645d35804b4902d31e9c6ed0c989b";
			
			btn_forums.addEventListener(MouseEvent.CLICK, loadForums);
			btn_forums.buttonMode    = true;
			btn_forums.mouseChildren = false;
			
			forum.addEventListener(ConstellationEvent.COMPLETE_FORUMS, forumsReady, false, 0, true);

			
			forum.addEventListener(ConstellationEvent.COMPLETE_TOPICS, topicsReady, false, 0, true);
			//forum.topics("com.galaxy.community.announcements-general");
			
			forum.addEventListener(ConstellationEvent.COMPLETE_MESSAGES, messagesReady, false, 0, true);
			//forum.messages("com.galaxy.community.announcements-general.4b5945928ead0e8501020000");
			
			forum.forums();
		}
		
		public function loadForums(e:MouseEvent):void
		{
			forum.forums();	
		}
		
		public function didSelectForum(id:String):void
		{
			currentTopic = id;
			forum.topics(id);
		}
		
		public function didSelectTopic(id:String):void
		{
			forum.messages(currentTopic+"."+id);
		}
		
		public function forumsReady(e:ConstellationEvent):void
		{
			var decoder : JSONDecoder = new JSONDecoder(e.data, true);
			var object  : Object = decoder.getValue();
			reloadData(object.response, Forum)
			
			
		}
		
		public function topicsReady(e:ConstellationEvent):void
		{
			var decoder : JSONDecoder = new JSONDecoder(e.data, true);
			var object  : Object = decoder.getValue();
			reloadData(object.response, Topic);
		}
		
		public function messagesReady(e:ConstellationEvent):void
		{
			var decoder : JSONDecoder = new JSONDecoder(e.data, true);
			var object  : Object = decoder.getValue();
			reloadData(object.response, Message);
		}
		
		public function constellationShouldGetForums(cn:Constellation):Boolean
		{
			return true;
		}
		
		public function constellationShouldGetTopicsForForum(cn:Constellation, forum:String):Boolean
		{
			return true;
		}
		
		public function constellationShouldGetMessagesForTopic(cn:Constellation, topic:String):Boolean
		{
			return true;
		}
		
		private function reloadData(values:Array, viewClass:Class):void
		{
			removeAllChildren();
			var position : int = 0;
			
			for (var i:Object in values)
			{
				var view : * = new viewClass();
				view.dataProvider = values[i];
				view.y = position;
				
				viewContainer.addChild(view);
				
				position += view.layoutHeight;
			}
			
		}
		
		private function removeAllChildren():void
		{
			var count : int = viewContainer.numChildren;

			if(count > 0)
			{
				for(var i : int = 0; i < count; i++)
				{
					viewContainer.removeChildAt(0)
				}
			}
		}
		
		
	}
}