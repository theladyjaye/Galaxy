<?php
/**
 *    Galaxy - Core
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
 *    @package galaxy
 *    @subpackage net
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyResponse
{
	private $_headers;
	private $_data;
	private $_error;
	private $_result;
	private $_raw_headers;
	
	public static function responseWithData($data)
	{
		$response = new GalaxyResponse();
		$response->setData($data);
		return $response;
	}
	
	private function setData($data)
	{
		$this->initializeResponse($data);
	}
	
	private function initializeResponse($data)
	{
		$body_begin  = strpos($data, "\r\n\r\n");
		$this->processHeaders(substr($data, 0, $body_begin));
		$this->_data = substr($data, ($body_begin+4), $this->headers['Content-Length']); // length of \r\n\r\n = 4
		
		$content_type = trim($this->headers['Content-Type']);
		
		switch($content_type)
		{
			case Galaxy::kFormatPHP:
				$this->_result = unserialize($this->_data);
				break;
			
			case Galaxy::kFormatXML:
			case Galaxy::kFormatJSON:
				$this->_result = $this->_data;
				break;
		}
	}
	
	private function processHeaders($headers)
	{
		$this->_raw_headers = $headers;
		
		$headers = explode("\r\n", $headers);
		
		$this->_headers['status'] = array_shift($headers);
		$status = explode(' ', $this->_headers['status']);
		$status = array_map('trim', $status);
		
		list($protocol, $code, $message) = $status;
		
		$this->_headers['status'] = array('protocol'=>$protocol, 'code'=>(int)$code, 'message'=>$message);
		
		foreach($headers as $header)
		{
			list($key, $value) = explode(':', $header);
			$key   = trim($key);
			$value = trim($value);
			$this->_headers[$key] = $value;
		}
	}
	
	public function __get($value)
	{
		switch($value)
		{
			case 'raw_headers':
				return $this->_raw_headers;
				break;
				
			case 'headers':
				return $this->_headers;
				break;
			
			case 'data':
				return $this->_data;
				break;
			
			case 'error':
				return $this->_error;
				break;
			
			case 'result':
				return $this->_result;
				break;
				
		}
	}
}
?>