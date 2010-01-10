<?php
class ApplicationIdValidator extends AMValidator
{
	// com.galaxy.community
	private $pattern = '/^(com|org|net|edu)\.[a-z0-9][a-z0-9-]{2,}\.[a-z0-9][a-z0-9-]{2,}$/';
	
	public function __construct($key, $required=false, $message=null)
	{
		$this->isRequired    =  $required;
		$this->shouldRequire =  $required ? false : true;
		$this->key           =  $key;
		$this->message       =  $message;
	}
	
	public function validate()
	{
		$value     = strtolower($this->form->{$this->key});
		
		$this->updateRequiredFlag($value);
		
		$this->isValid = filter_var($value, 
									FILTER_VALIDATE_REGEXP, 
									array("options"=>array("regexp"=>$this->pattern)));
	}
}
?>