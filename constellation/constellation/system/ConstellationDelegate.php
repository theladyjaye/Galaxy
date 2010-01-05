<?php
interface ConstellationDelegate
{
	// return booleans
	function constellationShouldShowForums($constellation);
	function constellationShouldShowTopics($constellation);
	function constellationShouldCreateTopic($constellation);
	function constellationShouldDeleteTopic($constellation);
	function constellationShouldCreateMessage($constellation);
	function constellationShouldDeleteMessage($constellation);
	
	function constellationWillShowForums($constellation, &$forums);
	function constellationWillShowTopics($constellation, &$topics);
	function constellationWillShowMessages($constellation, &$messages);
}
?>