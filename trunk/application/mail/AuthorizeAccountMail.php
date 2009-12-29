<?php
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