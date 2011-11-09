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
$back     = implode('.', array_slice(explode('.', $_GET['id']), 0, 4));
$details = json_decode($application->constellation->message($_GET['id']));
$details = $details->response;
?>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Constellation</title>
		<link type="text/css" rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="/resources/css/style.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-scrollspy.js"></script>
		<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-modal.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-alerts.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-twipsy.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-popover.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-dropdown.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-scrollspy.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-tabs.js"></script>
		<script type="text/javascript"  src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-buttons.js"></script>
		<script type="text/javascript"  src="resources/js/app.js"></script>
	</head>
	<body>

		<!-- The top navigation menu -->
		<?php 
		$docRoot = getenv("DOCUMENT_ROOT");
		include($docRoot.'/_header.php')
		 ?>
		&nbsp;
		<div class="container">

			<section id="forms">
				<div class="page-header">
					<h1>Thoughts?</h1>
				</div>
				<div class="row">

					<div class="span16">
						<form action="message_edit.php?id=<?php echo $_GET['id'] ?>" method="post" accept-charset="utf-8">
							<fieldset>
								<div class="clearfix">
									<label for="xlInput">
										Subject:
									</label>
									<div class="input">
										<input class="xlarge" id="inputSubject" name="inputSubject" size="30" type="text" value='<?php echo $details->title ?>'>
									</div>
								</div>
								<div class="clearfix">
									<label for="textarea">
										Message
									</label>
									<div class="input">
										<textarea class="xxlarge" id="inputBody" name="inputBody" rows="6"><?php echo $details->body ?></textarea>
										<span class="help-block">Don't be shy... Tell me what you're really thinking</span>
									</div>
								</div><!-- /clearfix -->
								<div class="actions">
									<a type="reset" class="btn" href='/topics_view.php?id=<?php echo $back ?>'>
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
	</body>
</html>


