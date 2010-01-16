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
 *    @package mail
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class AuthorizeAccountMail extends RenegadeMail
{
	protected $subject = 'Welcome To Project Renegade!';
	protected $text    = 'resources/mail/accountCreate.txt';
	protected $html    = 'resources/mail/accountCreate.html';
	
	private $key;
	
	public function __construct($recipients, $key)
	{
		$this->recipients = $recipients;
		$this->key = $key;
	}
	
	protected function dictionary()
	{
		return array('key'=>$this->key);
	}
	
}
?>