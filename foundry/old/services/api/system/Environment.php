<?php
require $_SERVER['DOCUMENT_ROOT'].'/phorm/database/couchdb/CouchDB.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/services/api/system/Application.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/services/api/net/RenegadeRequest.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/services/api/net/RenegadeAuthorization.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/services/api/system/Configuration.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Resources.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/utils/StringFunctions.php';

date_default_timezone_set('America/Los_Angeles');
header('Content-Type: application/json');

?>