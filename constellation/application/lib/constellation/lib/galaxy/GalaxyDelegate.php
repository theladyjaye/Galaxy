<?php
interface GalaxyDelegate
{
	// returns mixed
	function galaxyCachedResponseForCommand(GalaxyApplication $application, $command, $arguments=null);
}
?>