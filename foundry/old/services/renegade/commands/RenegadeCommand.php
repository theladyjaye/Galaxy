<?php
interface RenegadeCommand
{
	function request();
	function descriptor();
	function setAuthorization(RenegadeAuthorization $value);
}
?>