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
foreach($channels as $channel)
{
	$id          = urlencode($channel['id']);
	$description = $channel['description'];
	echo <<<HTML
	<div><a href="/topics/$id">$description</a></div>
HTML;
}
?>