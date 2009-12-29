<?php
class PHORMUniqueRecordValidator extends Validator
{
	public $column;
	public $object;
	public $isRequired;
	public $message;
	
	public function __construct(Form &$form, $key, $orm_object, $column=null, $required=false, $message=null)
	{
		$this->isRequired =  $required;
		$this->form       =  $form;
		$this->key        =  $key;
		$this->column     =  $column ? $column : $key;
		$this->object     =  $orm_object;
		$this->message    =  $message;
	}
	
	public function validate()
	{
		$q = phorm_query($this->object);
		$q->filter($this->object.'->'.$this->column.' = '.'"'.$this->form->{$this->key}.'"');
		$q->resultsAsArray = true;
		
		$record = $q->one();
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