<?php
$context_app = dirname(__FILE__);
require $context_app.'/application/system/Environment.php';
$application = Application::sharedApplication();
$application->initializeConstellation();
$messages = $application->constellation->topic_messages($_GET['id']);
$messages = json_decode($messages);

$back     = implode('.', array_slice(explode('.', $_GET['id']), 0, 4));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" charset="utf-8">
	<title>untitled</title>
</head>
<body>
	<div><a href="topics_view.php?id=<?php echo $back ?>">&laquo; Back</a></div>
	<div><a href="topics_new.php?id=<?php echo $_GET['id'] ?>&action=reply">&laquo; Reply</a></div>
	<hr>
	<div>
		<?php foreach ($messages as $message): ?>
			<?php
				$avatar      = $message->author_avatar_url ? $message->author_avatar_url  : '/resources/bitmaps/icon_no_avatar.png';
				$author_name = $message->author_name       ? $message->author_name : 'Unknown';
			?>
			<div style="padding-top:10px">
				<div style="background-color:#efefef; padding:7px"><?php echo $message->title ?></div>
				<div style="font-size:11px; font-style:italic">(Posted From: <a href="http://<?php echo $message->origin_domain ?>"><?php echo $message->origin_description ?></a> on <?php echo date('Y-m-d', strtotime($message->created))?> by: <?php echo $author_name ?>)</div>
				<div style="padding-top:10px; padding-bottom:10px; border-bottom:1px solid #cccccc">
						<div style="float:left;width:80px;"><img src="<?php echo $avatar ?>"></div>
					<div style="min-height:80px; padding-left:90px;"><?php echo $message->body ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</body>
</html>
