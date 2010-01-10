<?php
require $_SERVER['DOCUMENT_ROOT'].'/application/system/Environment.php';
require $_SERVER['DOCUMENT_ROOT'].'/application/controls/ErrorMessage.php';
//require $_SERVER['DOCUMENT_ROOT'].'/application/utils/UserFunctions.php';

class HomeViewController extends ViewController
{
	protected function page_load()
	{
		echo '<pre>',print_r($_SESSION, true), '</pre>';
		
		$session = session_currentSession();
		//$session = Application::session();
		
		echo $session->id,'<br>';
		echo $session->screenname;
		
		$user = user_currentUser();
		
		if($user)
		{
			//twitter_setStatusForUser('Simultaneous post to twitter and facebook part 2 via #CouchDB #PHP', $user);
			//facebook_setStatusForUser('Simultaneous post to twitter and facebook part 2 via CouchDB and PHP', $user);
		}
		
	}
	
	
	
	public function messages()
	{
		//$session = Application::session();
		//$form    = $session->forms['AccountAuthenticate'];
		$form    = session_formForKey('AccountAuthenticate');
		
		session_deleteFormForKey('AccountAuthenticate');
		//unset($session->forms['AccountAuthenticate']);
		
		if($form['messages'])
		{
			foreach($form['messages'] as $value)
			{
				echo new ErrorMessage($value);
			}
		}
	}
}
?>