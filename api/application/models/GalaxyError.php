<?php
class GalaxyError
{
	private $string;
	
	public static function errorWithString($string)
	{
		$error = new GalaxyError();
		$error->string = $string;
		return $error;
	}
	
	public function data()
	{
		return array('reason' => $this->string);
	}
}
?>