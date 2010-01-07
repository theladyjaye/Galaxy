<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/lib/constellation/Constellation.php';
require 'Application.php';

date_default_timezone_set('America/Los_Angeles');
if (session_id() == "") session_start();

new Application();
?>