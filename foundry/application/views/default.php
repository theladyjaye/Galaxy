<?php Page::CodeBehind('Home.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Welcome To Galaxy</title>
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/headings.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/navigation.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/footer.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $page->javascript() ?>
	<?php echo $page->css() ?>
</head>
<body>
<?php Navigation('home') ?>
<div id="content">
	<h1>Welcome to Galaxy</h1>
	
</div>
<?php Footer() ?>
</body>
</html>
