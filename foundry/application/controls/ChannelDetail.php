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
 *    @subpackage controls
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class ChannelDetail
{
	const kContextDefault      = 1;
	const kContextSubscription = 2;
	
	public $data;
	private $context;
	
	public function __construct($data, $context=ChannelDetail::kContextDefault)
	{
		$this->data = $data;
		$this->context = $context;
	}
	
	public function __toString()
	{
		switch($this->context)
		{
			case ChannelDetail::kContextDefault:
				$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetail.html';
				break;
			
			case ChannelDetail::kContextSubscription:
				$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelDetailSubscription.html';
				break;
			
		}
		
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>