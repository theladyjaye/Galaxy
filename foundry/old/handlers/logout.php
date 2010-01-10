<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
session_destroyCurrentSession();
header('location:/');
exit;
?>
