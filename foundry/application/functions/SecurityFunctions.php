<?php
/**
 *    Galaxy - Foundry
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package foundry
 *    @subpackage functions
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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
		$strong = false;
		
		while(!$strong)
		{
			$data = openssl_random_pseudo_bytes(512, $strong);
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
	return $key;
}


?>