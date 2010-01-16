<?php
/**
 *    Galaxy - Foundry
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
 *    @package foundry
 *    @subpackage system
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
require 'PHPApplication.php';
require 'Page.php';
require 'UserControl.php';

// Custom Environment
require $_SERVER['DOCUMENT_ROOT'].'/application/Renegade.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/RenegadeSession.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/RenegadeConstants.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/predis/Predis.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/axismundi/display/AMDisplayObject.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/viewcontrollers/ViewController.php';

date_default_timezone_set('America/Los_Angeles');
session_set_save_handler(array('RenegadeSession', 'open'),
                         array('RenegadeSession', 'close'),
                         array('RenegadeSession', 'read'),
                         array('RenegadeSession', 'write'),
                         array('RenegadeSession', 'destroy'),
                         array('RenegadeSession', 'gc')
                         );

// due to object serialization/unserialization class declaration requirements this needs to happen last:
if (session_id() == "") session_start();

?>