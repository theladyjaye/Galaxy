<?php
require 'GalaxyApplication.php';
require 'GalaxyCommand.php';
require 'GalaxyDelegate.php';
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
	
	const kDefaultLimit           = 25;
	const kDefaultPage            = 0;
	
	const kAuthorizationOAuth     = 'OAuth';
	const kAuthorizationOAuthWRAP = 'OAuth WRAP'; // not used, noted here because it may be used in the future. keep in mind for applicable code paths
	const kSchemeGalaxy           = 'glxy://';
}
?>