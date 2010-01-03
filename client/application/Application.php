<?php
require $_SERVER['DOCUMENT_ROOT'].'/galaxy/Galaxy.php';
class Application
{
	public static function galaxyForum()
	{
		$options  = array('id'     => 'com.galaxy.community',
		                  'key'    => '3be355bc06dc4923a3e894e5675e3f0a',
		                  'secret' => '91da6fc8ae68944913ac4f2f549886b2',
		                  'type'   => Galaxy::kApplicationForum,
		                  'format' => Galaxy::kFormatJSON);
		
		return Galaxy::applicationWithOptions($options);
	}
}
?>