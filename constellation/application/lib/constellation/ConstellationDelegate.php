<?php
interface ConstellationDelegate extends GalaxyDelegate
{
	// return booleans
	function constellationShouldGetForums(Constellation $constellation);
	
	function constellationShouldGetTopicsForForum(Constellation $constellation, &$forum);
	function constellationShouldPostTopic(Constellation $constellation, CNMessage &$message);
	//function constellationShouldDeleteTopic(Constellation $constellation);
	
	function constellationShouldGetMessagesForTopic(Constellation $constellation, &$topic);
	function constellationShouldPostMessage(Constellation $constellation, CNMessage &$message);
	//function constellationShouldDeleteMessage(Constellation $constellation);
}
?>