<?php

class EmailValidator extends Validator
{
	private $shouldRequire;
	private $regex = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
	
	//public function __construct($key, Form &$form, $required=false, $message=null)
	public function __construct(&$value, $required=false, $message=null)
	{
		$this->isRequired    =  $required;
		$this->shouldRequire =  $required ? false : true;
		$this->value         =& $value;
		$this->message       =  $message;
	}
	
	public function validate()
	{
		if($this->shouldRequire && strlen($this->value) > 0)
			$this->isRequired = true;
		else
			$this->isRequred = $this->shouldRequire ? false : true;
		
		if(preg_match($this->regex, $this->value))
		{
			$this->isValid = true;
		}
		else
		{
			$this->isValid = false;
		}
		
		//$this->form->{$this->key} = filter_var($this->form->{$this->key}, FILTER_SANITIZE_EMAIL);
		//echo $this->form->{$this->key};
		//$this->isValid = filter_var($this->form->{$this->key}, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>$this->regex)))));
		
	}
}
?>