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
class CNMessage
{
	private $id;
	private $title;
	private $body;
	private $author;
	private $context;
	
	public static function messageWithContext($context)
	{
		$message = new CNMessage();
		$message->context = $context;
		return $message;
	}
	
	public function setId($value)
	{
		$this->id = $value;
	}
	
	public function setTitle($value)
	{
		$this->title = $value;
	}
	
	public function setBody($value)
	{
		$this->body = $value;
	}
	
	public function data()
	{
		if(!$this->id)
		{
			$author = $this->author->data();
			
			if(empty($author))
			{
				throw new Exception('New Constellation message must be assigned an author');
			}
		}
		
		return array('id'                => $this->id,
			         'title'             => $this->title,
		             'body'              => $this->body,
		             'author_name'       => $author['name'],
		             'author_avatar_url' => $author['avatar_url']);
	}
	
	public function setAuthor(CNAuthor $value)
	{
		$this->author = $value;
	}
	
	public function context()
	{
		return $this->context;
	}
}
?>