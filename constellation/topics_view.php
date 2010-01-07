<?php
require 'application/system/Environment.php';
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
	<title>untitled</title>
</head>
<body>
	<div><a href="/">&laquo; Back</a></div>
	<div><a href="/topics/new/<?php echo $_GET['id'] ?>">New Topic</a>
	<hr>
	<div>
		<?php foreach($topics as $topic): ?>
			<?php
				$author_name = $topic->author_name ? $topic->author_name : 'Unknown'; 
			?>
			<div style="padding-bottom:20px">
				<div><a href="/topics/read/<?php echo $_GET['id']?>.<?php echo $topic->id ?>"><?php echo $topic->title ?></a></div>
				<div style="font-size:11px;font-style:italic;">(Created From: <a href="http://<?php echo $topic->origin_domain ?>"><?php echo $topic->origin_description ?></a> on <?php echo date('Y-m-d', $topic->created)  ?> by: <?php echo $author_name ?>)</div>
			</div>
		<?php endforeach;?>
	</div>
</body>
</html>
