<?php
class ErrorMessage
{
	private $message;
	function __construct($message) 
	{
		$this->message = $message;
	}
	
	public function __toString()
	{
		$dictionary = array('message' => $this->message);
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/ErrorMessage.html', $dictionary);
	}
}
?>