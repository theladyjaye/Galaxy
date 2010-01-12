<?php Page::CodeBehind('Subscriptions.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Galaxy - Channel Subscriptions <?php echo $_GET['id'] ?></title>
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/headings.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/navigation.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/footer.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/dialog.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $page->css() ?>
	<?php echo $page->javascript() ?>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/channels.js"></script>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/dialog.js"></script>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/json2.js"></script>
</head>
<body>
<?php Navigation('channels') ?>
<div id="content">
	<h1>Manage Subscriptions for: <?php echo $page->channel['label'] ?> (<?php echo $page->channel['_id'] ?>)</h1>
	<div id="channelFormContext" style="background:#efefef; width:100%;min-height:15px;">
		<div style="padding:10px;"><a href="/applications/<?php echo $page->channel['application'] ?>/channels" id="" title="<?php echo $page->channel['application'] ?>">&laquo; Back to Channel List</a></div>
	</div>
	<div>
		<div style="font-style:italic;font-size:11px;padding-bottom:10px"><?php echo $page->channel['description'] ?></div>
		<div id="subscriptions">
			<?php $page->showSubscriptions() ?>
		</div>
	</div>
</div>
<?php Footer() ?>
</body>
</html>
