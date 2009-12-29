<?php
class SuccessMessage
{
	private $message;
	function __construct($message) 
	{
		$this->message = $message;
	}
	
	public function __toString()
	{
		$dictionary = array('message' => $this->message);
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/SuccessMessage.html', $dictionary);
	}
}
?>