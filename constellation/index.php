<?php
$context_app = dirname(__FILE__);
require $context_app.'/application/system/Environment.php';
$application = Application::sharedApplication();
$application->initializeConstellation();
$forums = $application->constellation->forum_list();
$forums = json_decode($forums);
$forums = $forums->response;
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
		<?php include($docRoot.'/_header.php') ?>

		<div class="container">

			<!-- Main hero unit for a primary marketing message or call to action -->
			<div class="hero-unit">
				<h1>Welcome!</h1>
				<p>
					Constellation is very special content aggregator.  We allow you to get the opinion of the people that matter most to you.  Have something to say?  Just install our wordpress plugin and sign up for our API and let your voice be heard!
				</p>
				<p>
					<a class="btn primary large">Learn more &raquo;</a>
				</p>
			</div>

			<!-- Example row of columns -->
			<div class="row">
				<div class="span11">
					<h2>
					Channel Listing:
					<small>
						go ahead... click one
					</small>
					</h2>
					<table class="zebra-striped" id='channels-table'>
						<thead>
							<tr>
								<th>Show</th>
								<th>Description</th>
								<th>Views</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($forums as $forum): ?>
								<tr data-link='topics_view.php?id=<?php echo $forum->id ?>'>
									<td><?php echo $forum->label ?></td>
									<td><?php echo $forum->description ?></td>
									<td><?php echo $forum->requests ?></td>
								</tr>
							<?php endforeach;?>
							
						</tbody>
					</table>

					
				</div>

				<!-- This begins the second column -->
				<div class="span5">
					<h2>Lorem ipsum</h2>
					<p>
						Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
					</p>
					<ul class="tabs">
						<li class="active">
							<a href="#">Lorem</a>
						</li>
						<li>
							<a href="#">Ipsum</a>
						</li>
						<li>
							<a href="#">Dolor</a>
						</li>
					</ul>
					<p>
						Aenean tempor vulputate ipsum tempus elementum. Sed sit amet ligula nulla, non molestie lectus. Quisque felis lectus, pharetra dapibus semper id, vulputate sed ipsum. Pellentesque tincidunt pulvinar rhoncus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
					</p>
				</div>
			</div>

			<!-- Footer -->
			<footer>
				<p>
					&copy; Constellation 2011
				</p>
			</footer>

		</div> <!-- /container -->
	</body>
</html>
	
