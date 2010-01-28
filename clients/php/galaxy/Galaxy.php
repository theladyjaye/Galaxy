<?php
/**
 *    Galaxy - Core
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package galaxy
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
$context_galaxy = dirname(__FILE__);
require $context_galaxy.'/GalaxyApplication.php';
require $context_galaxy.'/GalaxyCommand.php';
require $context_galaxy.'/GalaxyDelegate.php';
require $context_galaxy.'/net/GalaxyConnection.php';
require $context_galaxy.'/net/GalaxyResponse.php';
require $context_galaxy.'/security/GalaxySignatureOAuth.php';

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