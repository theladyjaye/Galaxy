<?php
class Subscription
{
	private $certificate;
	private $application;
	private $channel;
	private $master = false;
	
	public function __construct() {}
	
	public function setCertificate($value)
	{
		$this->certificate = $value;
	}
	
	public function setApplication($value)
	{
		$this->application = $value;
	}
	
	public function setChannel($value)
	{
		$this->channel = $value;
	}
	
	public function setMaster($value)
	{
		$this->master = $value;
	}
	
	public function toArray()
	{
		$data =  array('application' => $this->application,
		               'channel'     => $this->channel,
		               'certificate' => $this->certificate,
		               'master'      => $this->master,
		               'type'        => RenegadeConstants::kTypeSubscription);
		
		return $data;
	}
}
?>