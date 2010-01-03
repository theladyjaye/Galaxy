<?php
class ChannelDetail
{
	public $data;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function __toString()
	{
		$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetail.html';
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>