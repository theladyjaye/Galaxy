<?php

class DomainValidator extends Validator
{
	private $regex = "/^[\w][\w\d]+\.[\w]{2,5}$/";
	private $shouldRequire;
	
	public function __construct(&$value, $required=false, $message=null)
	{
		$this->isRequired    =  $required;
		$this->shouldRequire =  $required ? false : true;
		$this->value         =& $value;
		$this->message       =  $message;
	}
	
	public function validate()
	{	
		/*if(preg_match($this->regex, $this->input[$this->key]))
			$this->isValid = true;
		else
			$this->isValid = false;
			*/
			
		if($this->shouldRequire && strlen($this->value) > 0)
			$this->isRequired = true;
		else
			$this->isRequred = $this->shouldRequire ? false : true;
		
			
		$this->isValid = filter_var($this->value, 
									FILTER_VALIDATE_REGEXP, 
									array("options"=>array("regexp"=>$this->regex)));
	}
}
?>