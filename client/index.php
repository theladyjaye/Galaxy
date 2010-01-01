<?php
require 'galaxy/Galaxy.php';

$key         = 'c49b1e9c75c8e2dce99d602ae4bb1019';
$secret      = 'aacc9ff43235f2ad1ff067ba3f3069c9';

$options  = array('id'     =>'com.galaxy.community',
                  'key'    => $key,
                  'secret' => $secret,
                  'type'   => Galaxy::kApplicationForum,
                  'format' => Galaxy::kFormatJSON);
$galaxy   = Galaxy::applicationWithOptions($options);
$channels = json_decode($galaxy->forum_list(), true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Forums</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Adam Venturella">
	<!-- Date: 2009-12-31 -->
</head>
<body>
	<h3>Forums</h3>
	<?php foreach($channels as $channel): ?>
	<div style="padding-bottom:10px">
		<div><a href="/topics/<?php echo $channel['id'] ?>"><?php echo $channel['description'] ?></a></div>
	</div>
	<?php endforeach;?>
</body>
</html>