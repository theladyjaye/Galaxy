<?php
class GalaxyForum extends GalaxyApplication
{
	protected function initialize()
	{
		
	}
	
	public function forums()
	{
		return $this->channels();
	}
	
	public function __toString()
	{
		return Galaxy::kApplicationForum;
	}
}
?>