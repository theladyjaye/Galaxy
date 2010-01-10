<?php
class UniqueEmailValidator extends AMValidator
{
	public function __construct($key, $required=false, $message=null)
	{
		$this->isRequired    =  $required;
		$this->shouldRequire =  $required ? false : true;
		$this->key           =  $key;
		$this->message       =  $message;
	}
	
	public function validate()
	{
		$value = $this->form->{$this->key};
		$this->updateRequiredFlag($value);
		
		// couchdb
		/*
		$db      = Renegade::database();
		$options = array('key'=>$value);
		$view    = $db->view('accounts/email', $options);
		
		if(count($view) == 0)
		{
			$this->isValid = true;
		}*/
		
		// redis
		$key    = RenegadeConstants::kTypeUser.':'.$value;
		$db     = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseUsers);
		$result = null;
		$result = $db->get($key);
		if(!$result) $this->isValid = true;
	}
}
?>