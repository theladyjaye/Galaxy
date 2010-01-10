<?php
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