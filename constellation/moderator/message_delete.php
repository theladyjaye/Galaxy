<?php
$dir               = dirname(__FILE__);
$position          = strrpos($dir, '/');
$context_moderator = substr($dir, 0, $position);
require $context_moderator.'/application/system/Environment.php';

$application = Application::sharedApplication();
$application->initializeConstellation();
$message = CNMessage::messageWithContext($_GET['id']);
$application->constellation->message_delete($message);
header('Location: /topics_view.php?id='.substr($_GET['id'], 0, strrpos($_GET['id'], '.')));
?>