<?php

function renegade_security_hash($value)
{
	return hash('sha256', $value);
}

function renegade_generate_token($salt=null)
{
	
	$key    = null;
	$data   = null; 
	if(function_exists('openssl_random_pseudo_bytes'))
	{
		echo 'using openssl_random_pseudo_bytes';exit;
		$strong = false;
		
		while(!$strong)
		{
			$data = openssl_random_pseudo_bytes(512, $strong);
			echo $data;exit;
		}
	}
	else
	{
		$stream = fopen('/dev/urandom', 'rb');
		//$stream = fopen('/dev/random', 'rb');

		if($stream)
		{
			$data   = fread($stream, 64);
			fclose($stream);
		}
	}
	
	$key =  hash('md5', base64_encode($data).$salt.uniqid(mt_rand(), true));
	echo $key;exit;
	return $key;
}


?>