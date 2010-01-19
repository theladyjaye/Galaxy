<?php
$dir               = dirname(__FILE__);
$position          = strrpos($dir, '/');
$context_moderator = substr($dir, 0, $position);
require $context_moderator.'/application/system/Environment.php';

$application = Application::sharedApplication();
$application->initializeConstellation();

if(count($_POST))
{
	$message = CNMessage::messageWithContext($_GET['id']);
	$message->setTitle($_POST['inputSubject']);
	$message->setBody($_POST['inputBody']);
	$application->constellation->message_update($message);
	header('Location: /topics_view.php?id='.substr($_GET['id'], 0, strrpos($_GET['id'], '.')));
}

$details = json_decode($application->constellation->message($_GET['id']));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" charset="utf-8">
	<title>Edit Message</title>
	<!-- Date: 2009-12-31 -->
</head>
<body>
<div><a href="<?php echo $back ?>">&laquo; Back</a></div>
<form action="message_edit.php?id=<?php echo $_GET['id'] ?>" method="post" accept-charset="utf-8">
	<div>Author:<?php echo $details->author_name ?></div>
	<div><label for="inputSubject">Subject:</label><input type="text" name="inputSubject" value="<?php echo $details->title ?>" id="inputSubject" size="40"></div>
	<div><textarea name="inputBody" id="inputBody" cols="90" rows="20"><?php echo $details->body ?></textarea></div>
	<input type="hidden" name="inputChannel" value="<?php echo $_GET['id'] ?>" id="inputChannel">
	<p><input type="submit" value="Continue &rarr;"></p>
</form>
</body>
</html>