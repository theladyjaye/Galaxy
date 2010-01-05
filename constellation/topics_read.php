<?php
require 'constellation/Constellation.php';
$galaxy   = Constellation::galaxyForum();
$messages = json_decode($galaxy->messages_list($_GET['id']));
$back     = implode('.', array_slice(explode('.', $_GET['id']), 0, 4));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>untitled</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Adam Venturella">
	<!-- Date: 2009-12-31 -->
</head>
<body>
	<div><a href="/topics/<?php echo $back ?>">&laquo; Back</a></div>
	<div><a href="/topics/reply/<?php echo $_GET['id'] ?>">&laquo; Reply</a></div>
	<hr>
	<div>
		<?php foreach ($messages as $message): ?>
			<div style="padding-top:10px">
				<div style="background-color:#efefef; padding:7px"><?php echo $message->title ?></div>
				<div style="font-size:11px; font-style:italic">(Posted From: <?php echo $message->origin_description ?> on <?php echo date('Y-m-d', $message->created)  ?>)</div>
				<div style="padding-top:10px; padding-bottom:10px; border-bottom:1px solid #cccccc">
					<?php echo $message->body ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</body>
</html>
