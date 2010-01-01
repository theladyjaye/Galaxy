<?php
require 'applications/GalaxyApplication.php';
require 'applications/GalaxyForum.php';
require 'commands/GalaxyCommands.php';
require 'commands/GalaxyCommandsForum.php';
require 'net/GalaxyConnection.php';
require 'net/GalaxyResponse.php';
require 'security/GalaxySignatureOAuth.php';

class Galaxy
{
	const kVersion                = '0.1';
	const kApplicationForum       = 'forum';
	
	const kFormatXML              = 'application/xml';
	const kFormatJSON             = 'application/json';
	const kFormatPHP              = 'application/php';
	
	const kLimitDefault           = 25;
	
	const kAuthorizationOAuth     = 'OAuth';
	const kAuthorizationOAuthWRAP = 'OAuth WRAP'; // not used, noted here because it may be used in the future. keep in mind for applicable code paths
	const kSchemeGalaxy           = 'glxy://';
	
	public static function applicationWithOptions($options)
	{
		$valid    = array('id'     => true,
		                  'key'    => true,
		                  'secret' => true,
		                  'format' => true,
		                  'type'   => true);
		
		$result   = array_diff_key($options, $valid);
		$instance = null;
		
		if(empty($result))
		{
			switch($options['type'])
			{
				case Galaxy::kApplicationForum:
					return self::forumWithOptions($options);
					break;
			}
		}
		else
		{
			throw new Exception('Invalid Application Options.  Only: id, key, secret, format, type are allowed/required');
		}
	}
	
	private static function forumWithOptions($options)
	{
		return new GalaxyForum($options);
	}
}
?>