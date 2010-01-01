<?php
class Application
{
	public $private;
	public $api_key;
	public $api_secret;
	
	private $description;
	private $id;
	private $type;
	private $owner;
	private $defaultPermissions = 0;
	private $certificate;
	
	public function __construct($id)
	{
		$this->id         = $id;
	}
	
	public function setApplicationOwner($value)
	{
		$this->owner = $value;
	}
	
	public function setDefaultPermissions($value)
	{
		$this->defaultPermissions = $value;
	}
	
	public function setDescription($value)
	{
		$this->description = $value;
	}
	
	public function setApplicationType($value)
	{
		$this->type = $value;
	}
	
	public function generate_certificate()
	{
		$certificate = false;
		
		if(!$this->certificate)
		{
			if($this->owner && $this->id)
			{
				require $_SERVER['DOCUMENT_ROOT'].'/application/models/Certificate.php';

				$certificate = new Certificate(Certificate::kContextApplication);
				$certificate->setData(array('owner'       => $this->owner,
				                            'instance'    => $this->type,
				                            'application' => $this->id,
				                            'description' => $this->description));
		
				$certificate       = $certificate->toArray();
				$this->certificate = $certificate;
			}
		}
		return $this->certificate;
	}
	
	public function generate_metadata()
	{
		if(!$this->certificate){
			$this->generate_certificate();
		}
		
		$metadata = false;
		
		if($this->owner && $this->id)
		{
			$metadata = array('_id'                 => $this->id,
			                  'database'            => Renegade::databaseForId($this->id),
			                  'instance'            => $this->type,
			                  'owner'               => $this->owner,
			                  'certificate'         => $this->certificate['key'],
			                  'description'         => $this->description,
			                  'defaultPermissions'  => $this->defaultPermissions,
			                  'created'             => time(),
			                  'type'                => RenegadeConstants::kTypeApplication
			             );
		}
		
		return $metadata;
	}
	
	private function application_key()
	{
		return urlencode($this->owner.'/'.$this->id);
	}
	
	
	public function __toString()
	{
		$session       = Renegade::session();
		$owner         = $session->user;
		$users         = array();
		$this->private = (bool) $this->private ? true : false;
		
		if($this->private)
		{
			$users[] = $owner;
		}
		
		return json_encode(array('owner'      => $owner,
		                         'api_key'    => $this->api_key,
		                         'api_secret' => $this->api_secret,
		                         'private'    => $this->private,
		                         'users'      => $users,
		                         'type'       => RenegadeConstants::kTypeChannel
		                  ));
	}
}
?>