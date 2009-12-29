<?php
class InputValidator extends Validator
{
	public $regex;
	public $minLength;
	public $maxLength;
	
	public function __construct(&$value, $required=false, $minLength=0, $maxLength=0, $regex=null, $message=null)
	{
		$this->isRequired =  $required;
		$this->regex      =  $regex;
		$this->minLength  =  $minLength;
		$this->maxLength  =  $maxLength;
		$this->value      =& $value;
		$this->message    =  $message;
	}
	
	public function validate()
	{
		if($this->minLength)
		{
			if(strlen($this->value) < $this->minLength)
			{
				$this->isValid  = false;
				return;
			}
			else
			{
				$this->isValid = true;
			}
		}
		
		if($this->maxLength)
		{
			if(strlen($this->value) <= $this->maxLength)
			{
				$this->isValid  = true;
			}
			else
			{
				$this->isValid = false;
				return;
			}
		}
		
		if($this->regex)
		{
			if(preg_match($this->regex, $this->value))
			{
				$this->isValid = true;
			}
			else
			{
				$this->isValid = false;
			}
		}
			
	}
}
?>