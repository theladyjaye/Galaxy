<?php

class UniqueApplicationShortNameValidator extends Validator
{
	public $value;
	public $isRequired;
	public $message;
	public $key;
	
	public function __construct(&$value, $required=false, $message=null)
	{
		$this->isRequired =  $required;
		$this->value      =& $value;
		$this->message    =  $message;
	}
	
	public function validate()
	{
		$db      = Database::connection();
		
		$options = array('key' => $this->value, 'limit' => 1);
		$view    = $db->view('applications/shortname', $options);
		
		$record  = $view[0]['value'];
		
		if(empty($record))
		{
			$this->isValid  = true;
		}
		else
		{
			$this->isValid = false;
		}
	}
}
?>