<?php Page::CodeBehind('Account.php'); ?>
<?php Register::Control('Navigation', 'Navigation.html.php'); ?>
<?php Register::Control('Footer', 'Footer.html.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Galaxy: Your Account</title>
	<link rel="stylesheet" href="/resources/css/global.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/headings.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/navigation.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/footer.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="/resources/css/dialog.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php echo $page->css() ?>
	<?php echo $page->javascript() ?>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/account.js"></script>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/dialog.js"></script>
	<script type="text/javascript" charset="utf-8" src="/resources/javascript/json2.js"></script>
	
</head>
<body>
<div id="dialog">
	<div class="context">
		Your Account Has Been Updated
	</div>
</div>
<?php Navigation('account') ?>
<div id="content">
	<h1>Galaxy: Your Account (<?php echo $page->authorizedUser() ?>)</h1>
	<hr>
	
	<form id="account" action="/actions/account/update" method="post">
		<h2>Change E-Mail</h2>
		<fieldset>
			<div>New E-Mail Address</div>
			<input type="text" name="inputEmail" value="" id="inputEmail">
			<div>Confirm E-Mail Address</div>
			<input type="text" name="inputEmailVerify" value="" id="inputEmailVerify">
		</fieldset>
		
		<h2>Change Password</h2>
		<fieldset>
			<div>New Password</div>
			<input type="password" name="inputPassword" value="" id="inputPassword">
			<div>Confirm Password</div>
			<input type="password" name="inputPasswordVerify" value="" id="inputPasswordVerify">
		</fieldset>
		<input type="submit" name="submit" value="Submit" id="submit">
	</form>
</div>
<?php Footer() ?>
</body>
</html>
