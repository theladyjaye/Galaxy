<?php
/**
 *    Galaxy - API
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
 *    @package api
 *    @subpackage system
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/predis/Predis.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/GalaxyAPI.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/GalaxyAPIConstants.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/net/GalaxyRequest.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/net/GalaxyResponse.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/GalaxyContext.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/GalaxyLog.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/models/GalaxyError.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/security/OAuthRequest.php';

date_default_timezone_set('America/Los_Angeles');
?>