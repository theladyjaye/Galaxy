<?php

class UniqueEmailValidator extends Validator
{
	public function __construct(&$value, $required=false, $message=null)
	{
		$this->isRequired =  $required;
		$this->value      =& $value;
		$this->message    =  $message;
	}
	
	public function validate()
	{
		$record = user_userForEmail($this->value);
		
		if($record)
		{
			$this->isValid  = false;
		}
		else
		{
			$this->isValid = true;
		}
	}
}
?>