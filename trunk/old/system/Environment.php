<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Configuration.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Session.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Application.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Resources.php';
require $_SERVER['DOCUMENT_ROOT'].'/phorm/application/PhormEnvironment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/display/Page.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/display/DisplayObject.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controllers/ViewController.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/SessionFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/StringFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/UserFunctions.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/Header.php';

date_default_timezone_set('America/Los_Angeles');

new Application();

// due to object serialization/unserialization class declaration requirements this needs to happen last:
if (session_id() == "") session_start();

?>