<?php
class GalaxyResponse
{
	// NOTE ALL DATA MUST BE SET AS A PHP ARRAY FROM THE RESPECTIVE COMMANDS
	private $data;
	
	public static function unauthorized()
	{
		header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
		exit;
	}
	
	public static function responseWithData($data)
	{
		$response       = new GalaxyResponse();
		$response->data = $data;
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