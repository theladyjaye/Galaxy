<?php
class ChannelView
{
	private $dictionary;
	function __construct($dictionary) 
	{
		$this->dictionary = $dictionary;
	}
	
	public function __toString()
	{
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelView.html', $this->dictionary);
	}
}
?>