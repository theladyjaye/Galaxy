<?php
$context_env = dirname(__FILE__);
$context_env = implode('/',array_slice(explode('/', $context_env), 0, -1));
require $context_env.'/lib/constellation/Constellation.php';
require 'Application.php';

date_default_timezone_set('America/Los_Angeles');
if (session_id() == "") session_start();

new Application();
?>