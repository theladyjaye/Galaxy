<?php
$context_app = dirname(__FILE__);
require $context_app.'/application/system/Environment.php';
$application = Application::sharedApplication();
$application->initializeConstellation();
$topics = $application->constellation->topic_list($_GET['id']);
$topics = json_decode($topics);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="/resources/javascript/lib/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/resources/javascript/constellation_moderator.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/constellation_moderator.css" type="text/css" media="screen" charset="utf-8">
	<title>untitled</title>
</head>
<body>
	<div><a href="index.php">&laquo; Back</a></div>
	<div><a href="topics_new.php?id=<?php echo $_GET['id'] ?>&action=new">New Topic</a>
	<hr>
	<!-- moderator -->
	<div id="moderator-panel">
		<a href="close" id="btn_moderator-panel_close" class="close">x</a>
		<h3>Moderator Controls</h3>
		<div class="context">
			<div><a href="delete_topic" id="btn_delete_topic">Delete Topic</a></div>
		</div>
	</div>
	<!-- /moderator -->
	<div>
		<?php foreach($topics as $topic): ?>
			<?php
				$author_name = $topic->author_name ? $topic->author_name : 'Unknown';
			?>
			<div style="padding-bottom:20px">
				<div><a href="topics_read.php?id=<?php echo $_GET['id']?>.<?php echo $topic->id ?>"><?php echo $topic->title ?></a> | <a href="moderate" class="btn_moderate" name="<?php echo $_GET['id']?>.<?php echo $topic->id ?>">Moderate</a></div>
				<div style="font-size:11px;font-style:italic;">(Created From: <a href="http://<?php echo $topic->origin_domain ?>"><?php echo $topic->origin_description ?></a> on <?php echo date('Y-m-d', strtotime($topic->created))  ?> by: <?php echo $author_name ?>)</div>
				<div style="font-size:11px;font-style:italic;">Views: <?php echo $topic->requests ?></div>
			</div>
		<?php endforeach;?>
	</div>
</body>
</html>
