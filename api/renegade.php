<?php
	$options = array('host' =>'sync.renegde.com', 
	                 'port' => 80);
	
	$db       = new CouchDB($options);
	$map      = "function(doc) { emit(doc._id, doc);}";
	$response = $db->temp_view($map);
	
	print_r($response);
?>