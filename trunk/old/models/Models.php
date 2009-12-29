<?php

class User extends CouchDBRecord
{
	const kProfileDefaultNormal = 'profile_default_normal.png';
	const kProfileDefaultBigger = 'profile_default_bigger.png';
	
	public function initWithColumns()
	{
		//$this->id                          = new PrimaryKey($this, 'uuid');
		$this->screenname                  = new TextField($this, 16, true);
		$this->username                    = new Username($this, true);
		$this->password                    = new MD5Password($this);
		$this->twitter_access_token        = new TextField($this, 100);
		$this->twitter_access_token_secret = new TextField($this, 100);
		$this->facebook_user               = new TextField($this, 10);
		$this->bitmap_normal               = new BitmapFile($this, new BitmapDimensions(48, 48, PHORM::IMAGE_CROP_FIT));
		$this->bitmap_bigger               = new BitmapFile($this, new BitmapDimensions(73, 73, PHORM::IMAGE_CROP_FIT));
		$this->creationDate                = new CreationTimestamp($this);
		$this->lastLogin                   = new UnixTimestamp($this);
		$this->isValid                     = new TextField($this, 5); 
	}
}

class Channel extends CouchDBRecord
{
	public function initWithColumns()
	{
		$this->user          = new TextField($this, 100);
		$this->label         = new TextField($this, 100);
		$this->short_label   = new TextField($this, 100);
		$this->key           = new TextField($this, 32);
		$this->secret        = new TextField($this, 32);
		$this->domain        = new TextField($this, 200);
		$this->created       = new TextField($this, 32);
	}
}

class Category extends CouchDBRecord
{
	public function initWithColumns()
	{
		$this->label                       = new TextField($this, 50);
		$this->parent                      = new TextField($this, 50);
	}
}

/*interface JSONSerialization
{
	function toJSON();
}

class CouchDBObejct implements JSONSerialization
{
	protected $document;
	
	public static function objectWithJSON($json)
	{
		$object = new __CLASS__();
		$object->document = json_decode($json);
		return $object;
	}
	
	public function toJSON()
	{
		return json_encode($this->document);
	}
	
	public function __set($property, $value)
	{
		if (!$this->document){
			$this->document = array();
		}
		
		$this->document[$property] = $value;
	}
	public function __get($property)
	{
		$value = null;
		
		if($property == 'id' || $property == 'rev'){
			$property = '_'.$property;
		}
		
		if (isset($this->document[$property])) {
			$value = $this->document[$property];
		}
		
		return value;
	}
	
	public function __toString()
	{
		return $this->toJSON();
	}
}

class User extends CouchDBObject
{
	const kProfileDefaultNormal = 'profile_default_normal.png';
	const kProfileDefaultBigger = 'profile_default_bigger.png';
	
	$this->screenname                  = new TextField($this, 16, true);
	$this->username                    = new Username($this, true);
	$this->password                    = new MD5Password($this);
	$this->twitter_access_token        = new TextField($this, 100);
	$this->twitter_access_token_secret = new TextField($this, 100);
	$this->facebook_user               = new TextField($this, 10);
	$this->bitmap_normal               = new BitmapFile($this, new BitmapDimensions(48, 48, PHORM::IMAGE_CROP_FIT));
	$this->bitmap_bigger               = new BitmapFile($this, new BitmapDimensions(73, 73, PHORM::IMAGE_CROP_FIT));
	$this->creationDate                = new CreationTimestamp($this);
	$this->lastLogin                   = new UnixTimestamp($this);
	
}
*/
?>