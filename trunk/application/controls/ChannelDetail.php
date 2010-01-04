<?php
class ChannelDetail
{
	const kContextDefault      = 1;
	const kContextSubscription = 2;
	
	public $data;
	private $context;
	
	public function __construct($data, $context=ChannelDetail::kContextDefault)
	{
		$this->data = $data;
		$this->context = $context;
	}
	
	public function __toString()
	{
		switch($this->context)
		{
			case ChannelDetail::kContextDefault:
				$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetail.html';
				break;
			
			case ChannelDetail::kContextSubscription:
				$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetailSubscription.html';
				break;
			
		}
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>