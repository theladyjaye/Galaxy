<?php
class UniqueChannelValidator extends AMValidator
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
		$value     = RenegadeConstants::kChannelPrefix.'/'.Channel::format($this->form->{$this->key});
		
		$this->updateRequiredFlag($value);
		
		$db        = Renegade::database();
		$response  = $db->info(urlencode($value));
		
		if(isset($response['error']) && $response['error'] == 'not_found')
		{
			$this->isValid = true;
		}
	}
}
?>