<?php
abstract class Validator
{
	public $isValid;
	public $isRequired;
	public $value;
	public $message;
	
	abstract public function validate();
}
?>