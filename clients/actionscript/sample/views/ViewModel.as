package sample.views
{
	import flash.display.MovieClip;
	
	public class ViewModel extends MovieClip
	{
		[Public]
		public var layoutHeight : int = 20;
		
		[Protected]
		protected var _dataProvider;
		
		public function ViewModel()
		{
			this.initialize();
		}
		
		protected function initialize():void {}
		
		public function set dataProvider(value:Object):void
		{
			_dataProvider = value;
		}
		
		public function get dataProvider():Object
		{
			return _dataProvider;
		}
	}
}
