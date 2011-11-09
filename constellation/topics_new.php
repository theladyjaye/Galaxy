<?php
if($_GET['action'] == 'reply')
{
	$back = 'topics_read.php?id='.$_GET['id'];
}
else
{
	$back = 'topics_view.php?id='.$_GET['id'];
}

if(count($_POST))
{
	$context_app = dirname(__FILE__);
	require $context_app.'/application/system/Environment.php';
	
	$application = Application::sharedApplication();
	$application->initializeConstellation();
	
	
	$author  = new CNAuthor();
	$author->setName('GodMoose');
	$author->setAvatarUrl('http://www.gravatar.com/avatar/1a6b4b96e9933a0259babb3a9d02f759.png');
	
	switch($_GET['action'])
	{
		case 'new':
			$message = CNMessage::messageWithContext($_POST['inputChannel']);
			$message->setTitle($_POST['inputSubject']);
			$message->setBody($_POST['inputMessage']);
			$message->setAuthor($author);
			$application->constellation->topic_new($message);
			header('Location: '.$back);
			break;
		
		case 'reply':
			$message = CNMessage::messageWithContext($_GET['id']);
			$message->setTitle($_POST['inputSubject']);
			$message->setBody($_POST['inputMessage']);
			$message->setAuthor($author);
			$application->constellation->message_new($message);
			header('Location: '.$back);
			break;
	}
}
$docRoot = getenv("DOCUMENT_ROOT");
?>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Constellation</title>
		<?php include($docRoot.'/_head.php') ?>
	</head>
	<body>

		<!-- The top navigation menu -->
		<?php 
		$docRoot = getenv("DOCUMENT_ROOT");
		include($docRoot.'/_header.php')
		 ?>
		 
		<div class="container">
			&nbsp;
			<section id="forms">
				<div class="page-header">
					<h1>Thoughts?</h1>
				</div>
				<div class="row">

					<div class="span16">
						<form action="topics_new.php?id=<?php echo $_GET['id'] ?>&action=<?php echo $_GET['action'] ?>" method="post" accept-charset="utf-8">
							<fieldset>
								<div class="clearfix">
									<label for="xlInput">
										Subject:
									</label>
									<div class="input">
										<input class="xlarge" id="inputSubject" name="inputSubject" size="30" type="text">
									</div>
								</div>
								<div class="clearfix">
									<label for="textarea">
										Message
									</label>
									<div class="input">
										<textarea class="xxlarge" id="inputMessage" name="inputMessage" rows="6"></textarea>
										<span class="help-block">Don't be shy... Tell me what you're really thinking</span>
									</div>
								</div><!-- /clearfix -->
								<div class="actions">
									<a type="reset" class="btn" href='<?php echo $back ?>'>
										Cancel
									</a>
									&nbsp;
									<input type="hidden" name="inputChannel" value="<?php echo $_GET['id'] ?>" id="inputChannel">
									<input type="submit" class="btn primary" value="Continue">
								</div>
							</fieldset>
						</form>
					</div>
				</div><!-- /row -->

				<br>

			</section>

			<!-- Footer -->
			<footer>
				<p>
					&copy; Constellation 2011
				</p>
			</footer>

		</div> <!-- /container -->
</html>

