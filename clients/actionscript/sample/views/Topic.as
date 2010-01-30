package sample.views
{
	import flash.events.MouseEvent;
	
	public class Topic extends ViewModel
	{
		[Stage]
		/*
			public var txt_title       : TextField;
			public var txt_views       : TextField;
			public var txt_replies     : textField;
		*/
		
		override protected function initialize():void
		{
			layoutHeight = 55;
			buttonMode = true;
			mouseChildren = false;
		}
		
		override public function set dataProvider(value:Object):void
		{
			super.dataProvider   = value;
			txt_title.text       = value.title;
			txt_views.text       = value.requests;
			txt_replies.text     = value.replies;
			
			this.addEventListener(MouseEvent.CLICK, didSelectTopic, false, 0, true);
		}
		
		private function didSelectTopic(e:MouseEvent):void
		{
			root['didSelectTopic'](_dataProvider.id);
		}
	}
}