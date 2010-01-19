<?php
class ConstellationHandler implements ConstellationDelegate
{
	/* Constellation Delegate */
	
	// return booleans
	function constellationShouldGetForums(Constellation $constellation)
	{
		return true;
	}
	
	function constellationShouldGetTopicsForForum(Constellation $constellation, &$forum)
	{
		return true;
	}
	
	function constellationShouldCreateTopic(Constellation $constellation, CNMessage &$message)
	{
		return true;
	}
	
	function constellationShouldGetMessage(Constellation $constellation, &$message_id)
	{
		return true;
	}
	
	function constellationShouldUpdateMessage(Constellation $constellation, CNMessage &$message)
	{
		return true;
	}
	
	function constellationShouldGetMessagesForTopic(Constellation $constellation, &$topic)
	{
		return true;
	}
	
	function constellationShouldCreateMessage(Constellation $constellation, CNMessage &$message)
	{
		return true;
	}
	
	function constellationShouldDeleteTopic(Constellation $constellation, &$topic_id)
	{
		return true;
	}
	
	
	/* Galaxy Delegate */
	
	function galaxyCachedResponseForCommand(GalaxyApplication $application, $command, $arguments=null)
	{
		$value = false;
		switch($command)
		{
			case Constellation::kCommandForumList:
				$value = null;//'[{"id":"com.galaxy.community.announcements","type":"channel","label":"Galaxy Announcements","description":"Announcements about the galaxy project here"},{"id":"com.galaxy.test.debugging","type":"channel","label":"Galaxy Debugging","description":"Test channel for debugging purposes"}]';
				break;
		}
		
		return $value;
	}
	
	function galaxySetCacheForResponse(GalaxyApplication $application, $command, $arguments=null, $response=null)
	{
		
	}
}
?>