<?php
require 'AMProxy.php';

$proxy = new AMProxy();
$proxy->setHost('www.bungie.net');
$proxy->setPort('80');

$proxy->proxy("/News/NewsRss.ashx");

echo $proxy->response->body;
?>