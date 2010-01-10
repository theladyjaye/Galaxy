<?php Page::CodeBehind('Applications.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Galaxy: Your Applications</title>
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
	<h1>Galaxy: Your Applications</h1>
	<!-- channel add -->
	<div id="channelFormContext" style="background:#efefef; width:100%;min-height:15px;">
		<div><a href="/actions/applications/show/add" id="channelAddAction">+</a></div>
		<div style="display:none" class="form">
			<form id="channelAddForm" action="/actions/application/create" method="post">
				<h3>Application General</h3>
				<label for="inputType">Application Type</label>
				<select type="text" name="inputType" id="inputType">
					<option value="<?php echo RenegadeConstants::kTypeForum ?>">Forum</option>
				</select><br>
				<label for="inputName">Application Display Name</label><input type="text" name="inputName" size="40" value="" id="inputName"><br>
				<label for="inputId">Application Id</label><input type="text" name="inputId" size="40" value="" id="inputId"><br>
				<div style="font-style:italic">(reverse-domain name style, wildcards are not allowed e.g., <span style="font-weight:bold">com.galaxy.community</span>)</div><br>
				<label for="inputDomain">Application Domain</label><input type="text" name="inputDomain" size="40" value="" id="inputDomain"><br>
				<hr>
				<h3>Default Channel Permissions</h3>
				<div style="width:300px;font-style:italic;padding-bottom:7px">Other users can perform the following actions to this application's channels without requesting permission.  You can customize this on a per channel basis as well, this is just the default setting.</div>
				<label for="inputRead">Read</label><input type="checkbox" name="inputRead" value="<?php echo RenegadeConstants::kPermissionRead ?>" id="inputRead"><br>
				<label for="inputWrite">Write</label><input type="checkbox" name="inputWrite" value="<?php echo RenegadeConstants::kPermissionWrite ?>" id="inputWrite"><br>
				<label for="inputDelete">Delete</label><input type="checkbox" name="inputDelete" value="<?php echo RenegadeConstants::kPermissionDelete ?>" id="inputDelete">
				<hr>
				<div>
					<input type="submit" name="" value="Create Application &raquo;" id="">
				</div>
			</form>
		</div>
	</div>
	<!-- /channel add -->
	<div>
		<h2>Application List</h2>
		<div id="channels">
			<?php $page->showApplications() ?>
		</div>
	</div>
</div>
<?php Footer() ?>
</body>
</html>
