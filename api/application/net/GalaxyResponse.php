<?php
/**
 *    Galaxy - API
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
 *    @package api
 *    @subpackage net
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyResponse
{
	// NOTE ALL DATA MUST BE SET AS A PHP ARRAY FROM THE RESPECTIVE COMMANDS
	private $data;
	
	public static function unauthorized()
	{
		//header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
		$response       = new GalaxyResponse();
		$error          = GalaxyError::errorWithString('unauthorized');
		$response->data = array('ok'=>false, 'type'=>GalaxyAPIConstants::kTypeError, 'errors'=>array($error->data()));
		return $response;
	}
	
	public static function responseWithError(GalaxyError $error)
	{
		$response       = new GalaxyResponse();
		$response->data = array('ok'=>false, 'type'=>GalaxyAPIConstants::kTypeError, 'errors'=>array($error->data()));
		return $response;
	}
	
	public static function errorResponseWithForm(AMForm $form)
	{
		$errors = array();
		foreach($form->validators as $validator)
		{
			if(!$validator->isValid)
			{
				$error    = GalaxyError::errorWithString($validator->message);
				$errors[] = $error->data();
			}
		}
		
		$response       = new GalaxyResponse();
		$response->data = array('ok'=>false, 'type'=>GalaxyAPIConstants::kTypeError, 'errors'=>$errors);
		return $response;
	}
	
	public static function responseWithData($data=null)
	{
		$response       = new GalaxyResponse();
		$response->data = array('ok'=>true, 'response'=>$data);
		return $response;
	}
	
	public function __toString()
	{
		$string = null;
		
		switch($_SERVER['HTTP_ACCEPT'])
		{
			case GalaxyAPIConstants::kFormatPHP:
				header('Content-Type: '.GalaxyAPIConstants::kFormatPHP);
				$string = serialize($this->data);
				break;
				
			case GalaxyAPIConstants::kFormatXML:
				header('Content-Type: '.GalaxyAPIConstants::kFormatXML);
				break;
			
			case GalaxyAPIConstants::kFormatJSON:
				header('Content-Type: '.GalaxyAPIConstants::kFormatJSON);
				$string = json_encode($this->data);
				break;
			
			default:
				self::unauthorized();
				break;
		}
		
		return $string;
	}
}
?>