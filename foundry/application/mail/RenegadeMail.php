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
abstract class RenegadeMail
{
	protected $fromName    = 'Galaxy Foundry';
	protected $fromAddress = 'agent@galaxyfoundry.com';
	protected $subject;
	protected $text;
	protected $html;
	protected $recipients;
	
	public function send()
	{
		$message = $this->prepareMessage();
		
		$mail             = new PHPMailer();
		$mail->SetFrom($this->fromAddress, $this->fromName);
		$mail->Subject    = $this->subject;

		$mail->AltBody    = $message['text'];
		$mail->MsgHTML($message['html']);


		foreach($this->recipients as $address){
			$mail->AddAddress($address);
		}

		$mail->Send();
	}
	
	protected function basePath()
	{
		return $_SERVER['DOCUMENT_ROOT'];
	}
	
	protected function prepareMessage()
	{
		
		$dictionary = $this->dictionary();
		
		$text = AMDisplayObject::initWithURLAndDictionary($this->basePath().'/'.$this->text, $dictionary);
		$html = AMDisplayObject::initWithURLAndDictionary($this->basePath().'/'.$this->html, $dictionary);
		
		return array('text' => $text->__toString(), 'html'=> $html->__toString());
	}
	
	protected abstract function dictionary();
	
	
	
}
?>