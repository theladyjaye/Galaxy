<?php
class Header
{
	function __construct() 
	{
		
	}
	
	public function __toString()
	{
		if(Application::current_user())
		{
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/Header_Authorized.html');
		}
		else
		{
			return AMDisplayObject::renderDisplayObjectWithURLAndDictionary($_SERVER['DOCUMENT_ROOT'].'/application/controls/Header.html');
		}
	}
}
?>