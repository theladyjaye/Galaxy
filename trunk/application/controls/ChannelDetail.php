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
		
		list($user, $name)     = explode('/', $this->data['_id']);
		$this->data['name']    = $name;
		$this->data['private'] = $this->data['private'] ? 'Yes' : 'No';
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>