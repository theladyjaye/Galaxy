<?php

function renegade_security_hash($value)
{
	return hash('sha256', $value);
}

function renegade_generate_token($salt=null)
{
	$key    = null;
	$stream = fopen('/dev/random', 'rb');
	
	if($stream)
	{
		$data   = fread($stream, 512);
		fclose($stream);
		$key =  hash('md5', base64_encode($data).$salt.uniqid(mt_rand(), true));
	}
	else
	{
		throw Exception('renegade_generate_token - Unable to open random filestream');
	}
	
	return $key;
}


?>