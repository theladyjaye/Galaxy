<?php Page::CodeBehind('Permissions.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Galaxy - Application Default Channel Permissions <?php echo $_GET['id'] ?></title>
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
	<h2>Galaxy - Application Default Channel Permissions</h2>
	<div>
		<h3><?php echo $page->application['description'] ?></h3>
		<div style="font-style:italic;font-size:11px;padding-bottom:10px">(<?php echo $_GET['id'] ?>)</div>
		<div id="permissions">
			<div style="padding-bottom:10px">Default Permissions when creating a new channel for this application</div>
			<form action="/actions/application/permissions/update" method="post" accept-charset="utf-8">
				<label for="inputRead">Read</label><input type="checkbox" name="inputRead" value="<?php echo RenegadeConstants::kPermissionRead ?>" <?php $page->defaultPermissionRead() ?> id="inputRead"><br>
				<label for="inputWrite">Write</label><input type="checkbox" name="inputWrite" value="<?php echo RenegadeConstants::kPermissionWrite ?>" <?php $page->defaultPermissionWrite() ?> id="inputWrite"><br>
				<label for="inputDelete">Delete</label><input type="checkbox" name="inputDelete" value="<?php echo RenegadeConstants::kPermissionDelete ?>" <?php $page->defaultPermissionDelete() ?> id="inputDelete">
				<input type="hidden" name="inputApplicationId" value="<?php echo $page->application['_id'] ?>" id="inputApplicationId">
				<p><button type="button"><a href="/applications">Cancel</a></button><input type="submit" value="Update &raquo;"></p>
			</form>
		</div>
	</div>
</div>
<?php Footer() ?>
</body>
</html>
