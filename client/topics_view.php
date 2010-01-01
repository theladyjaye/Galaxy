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
$topics   = $galaxy->topics_list($_GET['id']);

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
	<div><a href="/">&laquo; Back</a></div>
<div><a href="/topics/new/<?php echo $_GET['id'] ?>">New Topic</a>
</body>
</html>
