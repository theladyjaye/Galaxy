<?php
if($_GET['action'] == 'reply')
{
	$back = 'read/'.$_GET['id'];
}
else
{
	$back = $_GET['id'];
}

if(count($_POST))
{
	require 'application/system/Environment.php';
	
	$application = Application::sharedApplication();
	$application->initializeConstellation();
	
	
	$author  = new CNAuthor();
	$author->setName('logix812');
	$author->setAvatarUrl('http://www.gravatar.com/avatar/1a6b4b96e9933a0259babb3a9d02f759.png');
	
	switch($_GET['action'])
	{
		case 'new':
			$message = CNMessage::messageWithContext($_POST['inputChannel']);
			$message->setTitle($_POST['inputSubject']);
			$message->setBody($_POST['inputMessage']);
			$message->setAuthor($author);
			$application->constellation->topic_new($message);
			header('Location: /topics/'.$back);
			break;
		
		case 'reply':
			$message = CNMessage::messageWithContext($_GET['id']);
			$message->setTitle($_POST['inputSubject']);
			$message->setBody($_POST['inputMessage']);
			$message->setAuthor($author);
			$application->constellation->message_new($message);
			header('Location: /topics/'.$back);
			break;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>topics <?php echo $_GET['action'] ?></title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Adam Venturella">
	<!-- Date: 2009-12-31 -->
</head>
<body>
<div><a href="/topics/<?php echo $back ?>">&laquo; Back</a></div>
<form action="/topics/<?php echo $_GET['action'] ?>/<?php echo $_GET['id'] ?>" method="post" accept-charset="utf-8">
	<div><label for="inputSubject">Subject:</label><input type="text" name="inputSubject" value="" id="inputSubject" size="40"></div>
	<div><textarea name="inputMessage" id="inputMessage" cols="90" rows="20"></textarea></div>
	<input type="hidden" name="inputChannel" value="<?php echo $_GET['id'] ?>" id="inputChannel">
	<p><input type="submit" value="Continue &rarr;"></p>
</form>
</body>
</html>
