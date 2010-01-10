<?php
	interface IFormDelegate
	{
		public function willProcessForm(&$form);
		public function didProcessForm(&$form);
	}
?>