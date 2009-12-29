<?php
class MatchValidator extends Validator
{
	public function __construct(&$value1, &$value2, $required=false, $message=null)
	{
		$this->isRequired =  $required;
		$this->value      = array(&$value1, &$value2); 
		$this->message    =  $message;
	}
	
	public function validate()
	{
		if($this->value[0] == $this->value[1])
		{
			$this->isValid = true;
		}
		else
		{
			$this->isValid  = false;
		}
	}
}
?>