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
 *    @package foundry_forms
 *    @subpackage validators
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class UniqueUsernameValidator extends AMValidator
{
	public function __construct($key, $required=false, $message=null)
	{
		$this->isRequired    =  $required;
		$this->shouldRequire =  $required ? false : true;
		$this->key           =  $key;
		$this->message       =  $message;
	}
	
	public function validate()
	{
		$value = $this->form->{$this->key};
		$this->updateRequiredFlag($value);
		
		// couchdb
		/*
		$db   = Renegade::database();
		$user = $db->document($value);
		
		if($user['error'] == 'not_found')
		{
			$this->isValid = true;
		}
		*/
		
		// tokyo cabinet
		/*
		$db   = Renegade::database(RenegadeConstants::kDatabaseTokyoCabinet);
		if( $db->vsiz($value) === false) $this->isValid = true;
		*/
		
		// redis
		$key    = RenegadeConstants::kTypeUser.':'.$value;
		$db     = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseUsers);
		$result = null;
		$result = $db->get($key);
		if(!$result) $this->isValid = true;
		
	}
}
?>