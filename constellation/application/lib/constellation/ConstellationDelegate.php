<?php
/**
 *    Galaxy - Constellation
 * 
 *    Copyright (C) 2010 Adam Venturella
 *
 *    LICENSE:
 *
 *    Licensed under the Apache License, Version 2.0 (the "License"); you may not
 *    use this file except in compliance with the License.  You may obtain a copy
 *    of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *    This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 *    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR 
 *    PURPOSE. See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 *    Author: Adam Venturella - aventurella@gmail.com
 *
 *    @package constellation
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
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