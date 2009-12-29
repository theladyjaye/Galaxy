<?php Page::CodeBehind('Channels.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Galaxy: Manage Channels for: <?php echo $page->application['description'] ?> (<?php echo $page->application['_id'] ?>)</title>
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
	<h1>Manage Channels for: <?php echo $page->application['description'] ?> (<?php echo $page->application['_id'] ?>)</h1>
	<!-- channel add -->
	<div id="channelFormContext" style="background:#efefef; width:100%;min-height:15px;">
		<div><a href="/actions/channels/show/add" id="channelAddAction">+</a> | <a href="/actions/channels/subscribe" id="channelSubscribeAction">Subscribe to Channel</a> | <a href="/applications/" id="">Back to Applications</a></div>
		<div style="display:none" class="formSubscribe">
			<form id="channelSubscribe">
				<h3>Subscribe channel to <?php echo $page->application['instance'] ?> based application</h3>
				<label for="inputId">Channel Id</label><br>
				<input type="text" name="inputId" value="" id="inputId" size="50"><br><br>
				<input type="submit" name="" value="Subscribe to Channel &raquo;" id="">
			</form>
		</div>
		<div style="display:none" class="form">
			<form id="channelAddForm" action="/actions/channel/create" method="post">
				<h3>Add channel to <?php echo $page->application['instance'] ?> based application</h3>
				<label for="inputId">Channel Id</label><br>
				<span style="font-style:italic;"><?php echo $page->application['_id'] ?>.</span><input type="text" name="inputId" value="" id="inputId" size="35"><br><br>
				<label for="inputDescription">Channel Description</label><input type="text" name="inputDescription" value="" id="inputDescription" size="40">
				<h3>Channel Permissions</h3>
				<div style="width:300px;font-style:italic;padding-bottom:7px">Other users can perform the following actions to this channel without requesting permission:</div>
				<label for="inputRead">Read</label><input type="checkbox" name="inputRead" value="<?php echo RenegadeConstants::kPermissionRead ?>" <?php $page->defaultPermissionRead() ?> id="inputRead"><br>
				<label for="inputWrite">Write</label><input type="checkbox" name="inputWrite" value="<?php echo RenegadeConstants::kPermissionWrite ?>" <?php $page->defaultPermissionWrite() ?> id="inputWrite">
				<div>
					<input type="hidden" name="inputApplicationId" value="<?php echo $page->application['_id'] ?>" id="applicationId">
					<input type="hidden" name="inputCertificate" value="<?php echo $page->application['certificate'] ?>" id="inputCertificate">
					<input type="submit" name="" value="Add Channel &raquo;" id="">
				</div>
			</form>
		</div>
	</div>
	<!-- /channel add -->
	<div>
		<h2>Channel List</h2>
		<div id="channels">
			<?php $page->showChannels() ?>
		</div>
	</div>
</div>
<?php Footer() ?>
</body>
</html>
