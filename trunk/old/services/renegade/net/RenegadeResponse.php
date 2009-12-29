<?php
/**
 *    Renegade
 * 
 *    Copyright (C) 2009 Adam Venturella
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
 *    @package Renegade
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2009 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/

/**
 * Responsible for processing and making available Renegade's Response to Commands 
 *
 * @package Net
 * @author Adam Venturella
 */
class RenegadeResponse
{
	private $_headers;
	private $_data;
	private $_error;
	private $_result;
	
	/**
	 * undocumented function
	 *
	 * @param string $data 
	 * @return void
	 * @author Adam Venturella
	 */
	public static function responseWithData($data)
	{
		print_r($data);
		$response = new RenegadeResponse();
		$response->setData($data);
		return $response;
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $data 
	 * @return void
	 * @author Adam Venturella
	 */
	private function setData($data)
	{
		list($headers, $this->_data) = explode("\r\n\r\n", $data);
		$this->processHeaders($headers);
		
		if(strpos($this->_headers['Content-Type'], 'text') === false)
		{
			$this->_result = $this->_data;
		}
		else
		{
			$this->_result = json_decode($this->_data);
			
			if(isset($this->_result['error']))
			{
				$this->_error = array('error'=>$this->_result['error'], 'reason'=>$this->_result['reason']);
			}
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $headers 
	 * @return void
	 * @author Adam Venturella
	 */
	private function processHeaders($headers)
	{
		
		$headers = explode("\r\n", $headers);
		$this->_headers['status'] = array_shift($headers);
		
		foreach($headers as $header)
		{
			list($key, $value) = explode(':', $header);
			$key   = trim($key);
			$value = trim($value);
			$this->_headers[$key] = $value;
		}
	}
	
	/**
	 * undocumented function
	 *
	 * @param string $value 
	 * @return void
	 * @author Adam Venturella
	 */
	public function __get($value)
	{
		switch($value)
		{
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