<?php
require 'galaxy/Galaxy.php';

$key         = 'c49b1e9c75c8e2dce99d602ae4bb1019';
$secret      = 'aacc9ff43235f2ad1ff067ba3f3069c9';

$options  = array('id'     =>'com.galaxy.community',
                  'key'    => $key,
                  'secret' => $secret,
                  'type'   => Galaxy::kApplicationForum,
                  'format' => Galaxy::kFormatPHP);
$galaxy   = Galaxy::applicationWithOptions($options);
$channels = $galaxy->forums();

print_r($channels);
?>