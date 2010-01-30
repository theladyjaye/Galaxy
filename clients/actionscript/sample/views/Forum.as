package sample.views
{
	import flash.events.MouseEvent;
	public class Forum extends ViewModel
	{
		[Stage]
		/*
			public var txt_title       : TextField;
			public var txt_description : TextField;
			public var txt_views       : TextField;
		*/
		
		override protected function initialize():void
		{
			layoutHeight = 60;
			buttonMode = true;
			mouseChildren = false;
		}
		
		override public function set dataProvider(value:Object):void
		{
			super.dataProvider   = value;
			txt_title.text       = value.label;
			txt_description.text = value.description;
			txt_views.text       = value.requests;
			
			this.addEventListener(MouseEvent.CLICK, didSelectForum, false, 0, true);
		}
		
		private function didSelectForum(e:MouseEvent):void
		{
			root['didSelectForum'](_dataProvider.id);
		}
	}
}