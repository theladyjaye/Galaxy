package sample.views
{
	import flash.display.Loader;
	import flash.net.URLRequest;
	import flash.events.Event;
	
	public class Message extends ViewModel
	{
		[Public]
		public var avatarLoader : Loader;
		
		[Stage]
		/*
			public var txt_title    : TextField;
			public var txt_by       : TextField;
			public var txt_from     : TextField;
			public var txt_body     : TextField;
			public var avatar       : MovieClip;
		*/
		
		override protected function initialize():void
		{
			layoutHeight = 140;
		}
		
		override public function set dataProvider(value:Object):void
		{
			super.dataProvider   = value;
			
			avatarLoader         = new Loader();
			avatar.addChild(avatarLoader);
			
			txt_title.text       = value.title;
			txt_by.text          = value.author.name;
			txt_from.text        = value.source.description;
			txt_body.text        = value.body;
		
			avatarLoader.load(new URLRequest(value.author.avatar_url));
		}
	}
}