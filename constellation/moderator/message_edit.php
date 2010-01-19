<?php
$dir               = dirname(__FILE__);
$position          = strrpos($dir, '/');
$context_moderator = substr($dir, 0, $position);
require $context_moderator.'/application/system/Environment.php';

$application = Application::sharedApplication();
$application->initializeConstellation();

if(count($_POST))
{
	
	$context = array(AMForm::kDataKey => $_POST);
	$form    = AMForm::formWithContext($context);
	$message = new CNMessage();
	$message->setTitle($form->inputSubject);
	$message->setBody($form->inputBody);
	$message->setId($_GET['id']);
	$application->constellation->message_update($message);
	//header('Location: /topics_view.php?id='.$id);
}

$details = json_decode($application->constellation->message_details($_GET['id']));
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
	<div><label for="inputAuthorName">Author Name:</label><input type="text" name="inputAuthorName" value="<?php echo $details->author_name ?>" id="inputAuthorName" size="40"></div>
	<div><label for="inputSubject">Subject:</label><input type="text" name="inputSubject" value="<?php echo $details->title ?>" id="inputSubject" size="40"></div>
	<div><textarea name="inputBody" id="inputBody" cols="90" rows="20"><?php echo $details->body ?></textarea></div>
	<input type="hidden" name="inputChannel" value="<?php echo $_GET['id'] ?>" id="inputChannel">
	<p><input type="submit" value="Continue &rarr;"></p>
</form>
</body>
</html>