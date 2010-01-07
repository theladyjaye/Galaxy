<?php
class CNAuthor
{
	private $name;
	private $avatar_url;
	
	public function setName($value)
	{
		$this->name = $value;
	}
	
	public function setAvatarUrl($value)
	{
		$this->avatar_url = $value;
	}
	
	public function data()
	{
		return array('name'       => $this->name,
		             'avatar_url' => $this->avatar_url
		            );
	}
}
?>