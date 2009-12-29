<?php
class Channel
{
	public $private;
	public $api_key;
	public $api_secret;
	
	private $application;
	private $certificate;
	private $permissions;
	private $id;
	private $description;
	private $defaultPermissions;
	private $instance;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function setInstance($value)
	{
		$this->instance = $value;
	}
	
	public function setDescription($value)
	{
		$this->description = $value;
	}
	
	public function setCertificate($value)
	{
		$this->certificate = $value;
	}
	
	public function setApplication($value)
	{
		$this->application = $value;
	}
	
	public function setDefaultPermissions($value)
	{
		$this->defaultPermissions = (int) $value;
	}
	
	public function generate_certificate($permissions=0)
	{
		require $_SERVER['DOCUMENT_ROOT'].'/application/models/Certificate.php';
		$certificate = new Certificate(Certificate::kContextChannel);
		
		$certificate->setData(array('certificate' => $this->certificate,
		                            'id'          => $this->channelId(),
		                            'permissions' => $permissions));
		
		return $certificate->toArray();
	}
	
	public function generate_metadata()
	{
		$metadata = false;
		
		$metadata = array('_id'                  => $this->channelId(),
			               'database'            => Renegade::databaseForId($this->channelId()),
			               'application'         => $this->application,
			               'description'         => $this->description,
			               'defaultPermissions'  => $this->defaultPermissions,
			               'created'             => time(),
			               'type'                => RenegadeConstants::kTypeChannel
			             );
		
		
		return $metadata;
	}
	
	private function channelId()
	{
		return $this->application.'.'.$this->id;
	}
}
?>