<?php
class Navigation extends UserControl
{
	public $selected;
	private $style = 'style="color:#cc0000"';
	
	protected function page_load($argc=0, $argv=null)
	{
		$dir        = dirname(__FILE__);
		$options    = array();
		$navigation = null;
		$source     = Renegade::hasAuthorizedUser() ? $dir.'/NavigationAuthorizedTrue.html' : $dir.'/NavigationAuthorizedFalse.html';
		$navigation = AMDisplayObject::initWithURLAndDictionary($source, $options);
		echo $navigation;
	}
}
?>