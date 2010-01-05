<?php
require $_SERVER['DOCUMENT_ROOT'].'/galaxy/Galaxy.php';
class Constellation
{
	public static function galaxyForum()
	{
		$options  = array('id'     => 'com.galaxy.community',
		                  'key'    => '3be355bc06dc4923a3e894e5675e3f0a',
		                  'secret' => '91da6fc8ae68944913ac4f2f549886b2',
		                  'type'   => Galaxy::kApplicationForum,
		                  'format' => Galaxy::kFormatJSON);
		
		/*$options  = array('id'   => 'com.galaxy.test',
                          'key'    => '1bf4c3f64356105adf2ef8f2ca3d93f1',
                          'secret' => '09fbd49752ad401d535b715df5b8770f',
                          'type'   => Galaxy::kApplicationForum,
                          'format' => Galaxy::kFormatJSON);*/
		
		return Galaxy::applicationWithOptions($options);
	}
}
?>