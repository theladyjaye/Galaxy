<?php
interface GalaxyDelegate
{
	// returns mixed
	function galaxyCachedResponseForCommand(GalaxyApplication $application, $command, $arguments=null);
	function galaxySetCacheForResponse(GalaxyApplication $application, $command, $arguments=null, $response=null);
}
?>