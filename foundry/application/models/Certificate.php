<?php
class Certificate
{
	const kContextApplication = 1;
	const kContextChannel     = 2;
	
	private $data;
	private $key;
	private $secret;
	private $salt;
	private $context;
	
	public function __construct($context=Certificate::kContextApplication)
	{
		$this->context = $context;
	}
	
	public function setSalt($value)
	{
		$this->salt = $value;
	}
	
	public function setData($value)
	{
		$this->data = $value;
	}
	
	private function prepare(&$data)
	{
		
		switch($this->context)
		{
			case Certificate::kContextApplication:
				$this->prepareApplicationCertificate($data);
				break;
			
			case Certificate::kContextChannel:
				$this->prepareChannelCertificate($data);
				break;
			
			default:
				$this->prepareApplicationCertificate($data);
				break;
		}
	}
	
	protected function prepareApplicationCertificate(&$data)
	{
		$this->key      = renegade_generate_token($this->data['application']);
		$this->secret   = renegade_generate_token($this->data['application']);
		$data['key']    = $this->key;
		$data['secret'] = $this->secret;
		
		if($this->data)
		{
			$data = array_merge($data, $this->data);
		}
		
		$data = array('key'   => RenegadeConstants::kTypeCertificate.':'.$this->key,
		              'value' => $data);
	}
	
	protected function prepareChannelCertificate(&$data)
	{
		$data['key']   = $this->data['certificate'].':'.$this->data['id'];
		$data['value'] = json_encode((int)$this->data['permissions']);
	}
	
	public function toArray()
	{
		$data = array();
		$this->prepare($data);
		return $data;
	}
	
	public function __get($key)
	{
		switch($key)
		{
			case 'key':
			case 'secret':
				return $this->{$key};
				break;
		}
	}
}
?>