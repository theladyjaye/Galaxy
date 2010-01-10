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
	private $label;
	private $description;
	private $defaultPermissions;
	private $instance;
	
	public function __construct($id)
	{
		// if we are given a full channel name:
		// com.galaxy.community.announcements
		// we only want the 'announcements' part
		if(strpos($id, '.') !== false)
		{
			$parts = explode('.', $id);
			
			if(count($parts) == 4)
			{
				$id = $parts[3];
				$this->application = implode('.', array_slice($parts, 0,3));
			}
			else
			{
				throw new Exception("Invalid 'id' provided in Channel::__construct");
			}
		}
		
		$this->id = $id;
	}
	
	public function setInstance($value)
	{
		$this->instance = $value;
	}
	
	public function setLabel($value)
	{
		$this->label = $value;
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
			               'label'               => $this->label,
			               'description'         => $this->description,
			               'defaultPermissions'  => $this->defaultPermissions,
			               'requests'            => 0,
			               'created'             => Renegade::datetime(),
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