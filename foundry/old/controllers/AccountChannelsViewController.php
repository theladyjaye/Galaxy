<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ErrorMessage.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ChannelView.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/SuccessMessage.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/forms/custom/ChannelCreate.php';

class AccountChannelsViewController extends ViewController
{
	protected $authenticationRequired = true;
	
	public $user;
	public $messages;
	
	protected function page_load()
	{
		if($this->isPostBack)
		{
			if(isset($_POST['ChannelCreate']))
			{
				new ChannelCreate();
			}
		}
		
		$this->user = Application::current_user();
		
		if(!$this->user){
			header('location:/account/logout');
		}
	}
	
	public function channels()
	{
		$session = session_currentSession();
		if ($session->isValid)
		{
			$dbh = Database::connection();
			//startkey=[%22f85638dfeff04bc1dec252ba2f8ed287%22,%20null]&endkey=[%22f85638dfeff04bc1dec252ba2f8ed287%22,%20{}]
			$session = session_currentSession();
		
		
			$startkey = array($session->id, null);
			$endkey   = array($session->id, (object) null);//(object) null OR new stdClass do the same thing
			$options = array('startkey' => $startkey, 'endkey' => $endkey);
		
			$view = $dbh->view('applications/user', $options);

			foreach($view as $document)
			{
				echo new ChannelView($document);
			}
		}
		else
		{
			echo 'Account Not Authorized to create Channels <a href="#">Resend Authorization E-mail</a>';
		}
	}
	
	public function messages()
	{
		if($this->messages)
		{
			foreach($this->messages as $value)
			{
				echo new ErrorMessage($value);
			}
		}
		
		if($_GET['status'] == 'success')
		{
			echo new SuccessMessage(LocalizedStringForKey("SuccessSettings"));
		}
	}
}
?>