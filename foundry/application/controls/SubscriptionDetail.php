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
class SubscriptionDetail
{
	
	public $data;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function __toString()
	{
		$source  = $_SERVER['DOCUMENT_ROOT'].'/application/controls/SubscriptionDetail.html';
		
		$this->data['permission_read']   = RenegadeConstants::kPermissionRead;
		$this->data['permission_write']  = RenegadeConstants::kPermissionWrite;
		$this->data['permission_delete'] = RenegadeConstants::kPermissionDelete;
		$this->data['has_read']          = ($this->data['permissions'] & RenegadeConstants::kPermissionRead)   ? 'checked' : '';
		$this->data['has_write']         = ($this->data['permissions'] & RenegadeConstants::kPermissionWrite)  ? 'checked' : '';
		$this->data['has_delete']        = ($this->data['permissions'] & RenegadeConstants::kPermissionDelete) ? 'checked' : '';
		$this->data['action']            = $_SERVER['REDIRECT_URL'];
		return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($source, $this->data);
		
	}
}
?>