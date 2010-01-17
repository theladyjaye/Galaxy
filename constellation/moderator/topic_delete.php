<?php
$dir               = dirname(__FILE__);
$position          = strrpos($dir, '/');
$context_moderator = substr($dir, 0, $position);
require $context_moderator.'/application/system/Environment.php';

$application = Application::sharedApplication();
$application->initializeConstellation();
$application->constellation->topic_delete($_GET['id']);

$position = strrpos($_GET['id'], '.');
$id       = substr($_GET['id'], 0, $position);

header('Location: /topics_view.php?id='.$id);
?>