<?php
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