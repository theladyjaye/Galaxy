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
class CNTopicMessages extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'messages';
}

class CNTopicNew extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'topics';
}

class CNTopicList extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodGet;
	public $endpoint = 'topics';
}

class CNMessageNew extends GalaxyCommand
{
	public $method   = GalaxyCommand::kMethodPost;
	public $endpoint = 'messages';
}
?>