<?php
/**
 *    Galaxy - API
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
 *    @package api_models
 *    @subpackage forum
 *    @author Adam Venturella <aventurella@gmail.com>
 *    @copyright Copyright (C) 2010 Adam Venturella
 *    @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 *
 **/
class GalaxyForumTopic
{
	private $context;
	private $title;
	private $author_name;
	private $author_avatar_url;
	
	public static function topicWithContext(GalaxyContext $context)
	{
		$topic          = new GalaxyForumTopic();
		$topic->context = $context;
		return $topic;
	}
	
	public function setTitle($value)
	{
		$this->title = $value;
	}
	
	public function setAuthorName($value)
	{
		$this->author_name = $value;
	}
	
	public function setAuthorAvatarUrl($value)
	{
		$this->author_avatar_url = $value;
	}
	
	public function data()
	{
		return array('_id'                => (string) new MongoID(),
			         'title'              => $this->title,
			         'author_name'        => $this->author_name,
		             'author_avatar_url'  => $this->author_avatar_url,
		             'origin'             => $this->context->origin,
		             'origin_description' => $this->context->origin_description,
		             'origin_domain'      => $this->context->origin_domain,
		             'created'            => GalaxyAPI::datetime(),
		             'type'               => GalaxyAPIConstants::kTypeForumTopic);
	}
}
?>