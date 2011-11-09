<?php
$context_app = dirname(__FILE__);
require $context_app.'/application/system/Environment.php';
$application = Application::sharedApplication();
$application->initializeConstellation();
$messages = $application->constellation->topic_messages($_GET['id']);
$messages = json_decode($messages);
$messages = $messages->response;

$back     = implode('.', array_slice(explode('.', $_GET['id']), 0, 4));
$channel  = substr($_GET['id'], 0, strrpos($_GET['id'], '.'));
$mainMessage = array_shift($messages);
$docRoot = getenv("DOCUMENT_ROOT");
?>

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<title>Constellation</title>
		<?php include($docRoot.'/_head.php') ?>		
	</head>
	<body>

		<!-- The top navigation menu -->
		<?php 
		$docRoot = getenv("DOCUMENT_ROOT");
		include($docRoot.'/_header.php')
		 ?>
		 
		<ul class="breadcrumb">
			<li>
				<a href="/">Home</a>
				<span class="divider">/</span>
			</li>
			<li>
				<a href="topics_view.php?id=<?php echo $back ?>">Topics</a>
				<span class="divider">/</span>
			</li>
			<li class="active">
				Post
			</li>
		</ul>
		<div class="container">
			<?php
				$avatar      = $mainMessage->author->avatar_url ? $mainMessage->author->avatar_url  : '/resources/bitmaps/icon_no_avatar.png';
				$author_name = $mainMessage->author->name       ? $mainMessage->author->name : 'Unknown';
			?>
			<div class="row post">
				<div class="media-grid span3">
					<a>
					<img class="thumbnail" src="<?php echo $avatar ?>" alt="">
					</a>
				</div>
				<h1><?php echo $mainMessage->title ?></h1>
				<div class="row">
					<h6><?php echo $author_name ?></h6>
					<span class="label"><?php echo date('d/m/Y - h:ma', strtotime($mainMessage->created))?></span>
				</div>
				<div class="row">
					<h3 class='offset3'><?php echo $mainMessage->body ?></h3>
				</div>
			</div>
			<hr />
			<div class="well">
				<a href="topics_view.php?id=<?php echo $back ?>" class="btn large">Back</a>
				&nbsp;
				<a href="topics_new.php?id=<?php echo $_GET['id'] ?>&action=reply" class="btn large primary">Reply</a>
			</div>
			<!--comments-->
			<?php foreach ($messages as $message): ?>
			<?php
				$avatar      = $message->author->avatar_url ? $message->author->avatar_url  : '/resources/bitmaps/icon_no_avatar.png';
				$author_name = $message->author->name       ? $message->author->name : 'Unknown';
			?>
			<div class="comment">
				<div class="row">
					<div class="media-grid span3 offset1">
						<a>
						<img class="thumbnail" src="<?php echo $avatar?>" alt="">
						</a>
					</div>
					<div class="span12">
						<h2 ><?php echo $message->title ?></h2>
						<h6><?php echo $author_name ?></h6>
						<!--<span class="label">05/07/2011 - 5:56pm</span>-->
						<span class="label"><?php echo date('d/m/Y - h:ma', strtotime($message->created))?></span>
						<div class='thread-response'>
							<?php echo $message->body ?>
						</div>
					</div>
				</div>
				&nbsp;
				<div class='row'>
					<a class="btn offset12" href='http://<?php echo $message->source->domain ?>'>
						Origin
					</a>&nbsp;
					<a class="btn success" href='/moderator/message_edit.php?id=<?php echo $channel.'.'.$message->id ?>'>
						Edit
					</a>&nbsp;
					<a class="btn danger" href='/moderator/message_delete.php?id=<?php echo $channel.'.'.$message->id ?>'>
						Delete
					</a>
				</div>
				<hr/>
			</div>
			
			
			<?php endforeach; ?>
			<!--
			<?php foreach ($messages as $message): ?>
			<?php
				$avatar      = $message->author->avatar_url ? $message->author->avatar_url  : '/resources/bitmaps/icon_no_avatar.png';
				$author_name = $message->author->name       ? $message->author->name : 'Unknown';
				
			?>
			<div style="padding-top:10px">
				<div style="background-color:#efefef; padding:7px"><?php echo $message->title ?> | Moderation: <a href="/moderator/message_edit.php?id=<?php echo $channel.'.'.$message->id ?>">Edit Message</a> : <a href="/moderator/message_delete.php?id=<?php echo $channel.'.'.$message->id ?>">Delete Message</a></div>
				<div style="font-size:11px; font-style:italic">(Posted From: <a href="http://<?php echo $message->source->domain ?>"><?php echo $message->source->description ?></a> on <?php echo date('Y-m-d', strtotime($message->created))?> by: <?php echo $author_name ?>)</div>
				<div style="padding-top:10px; padding-bottom:10px; border-bottom:1px solid #cccccc">
						<div style="float:left;width:80px;"><img src="<?php echo $avatar ?>"></div>
					<div style="min-height:80px; padding-left:90px;"><?php echo $message->body ?></div>
				</div>
			</div>
		<?php endforeach; ?>
		-->

			<!-- Footer -->
			<div class="well">
				<a href="topics_view.php?id=<?php echo $back ?>" class="btn large">Back</a>
				&nbsp;
				<a href="topics_new.php?id=<?php echo $_GET['id'] ?>&action=reply" class="btn large primary">Reply</a>
			</div>
			<footer>
				<p>
					&copy; Constellation 2011
				</p>
			</footer>

		</div> <!-- /container -->
	</body>
</html>
		<!--
		<?php foreach ($messages as $message): ?>
			<?php
				$avatar      = $message->author->avatar_url ? $message->author->avatar_url  : '/resources/bitmaps/icon_no_avatar.png';
				$author_name = $message->author->name       ? $message->author->name : 'Unknown';
			?>
			<div style="padding-top:10px">
				<div style="background-color:#efefef; padding:7px"><?php echo $message->title ?> | Moderation: <a href="/moderator/message_edit.php?id=<?php echo $channel.'.'.$message->id ?>">Edit Message</a> : <a href="/moderator/message_delete.php?id=<?php echo $channel.'.'.$message->id ?>">Delete Message</a></div>
				<div style="font-size:11px; font-style:italic">(Posted From: <a href="http://<?php echo $message->source->domain ?>"><?php echo $message->source->description ?></a> on <?php echo date('Y-m-d', strtotime($message->created))?> by: <?php echo $author_name ?>)</div>
				<div style="padding-top:10px; padding-bottom:10px; border-bottom:1px solid #cccccc">
						<div style="float:left;width:80px;"><img src="<?php echo $avatar ?>"></div>
					<div style="min-height:80px; padding-left:90px;"><?php echo $message->body ?></div>
				</div>
			</div>
		<?php endforeach; ?>
		-->
