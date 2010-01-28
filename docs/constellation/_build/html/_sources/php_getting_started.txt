***************
Getting Started
***************

Overview
=========

The Constellation PHP library is composed of 2 primiary pieces:

- **Constellation.php** *(extends GalaxyApplication)*
- **ConstellationDelegate.php** *(extends GalaxyDelegate)*

To initialize an instance of Constellation is as easy as::

	<?php
	require 'path/to/Constellation.php';
	$constellation         = new Constellation();
	$constellation_handler = new ConstellationHandler(); // ConstellationHandler implements ConstellationDelegate
	$constellation->setDelegate($constellation_handler);
	?>

Constellation.php is the core command class that talks to Galaxy to retrieve and send data.

ConstellationDelegate.php is an interface that is required by all Constellation instances.  ConstellationDelegate.php provides all of your override points for any action Constellation will perform.


Constellation Setup
====================

Once you have downloaded the Constellation libary, you will need to add the following to Constellation.php

- Application ID
- Application API Key
- Application API Secret

Open Constellation.php and find the following::

	protected $application_id     = 'your_application_id';
	protected $application_key    = 'your_application_key';
	protected $application_secret = 'your_application_secret';

Replace them with the values for your application which you can retrieve from the Galaxy Foundry application management screen::

	protected $application_id     = 'com.galaxy.community';
	protected $application_key    = 'acbd18db4cc2f85cedef654fccc4a4d8'; // don't get any ideas, this is md5('foo');
	protected $application_secret = '37b51d194a7513e45b56f6524f2d51f2'; // and this is md5('bar');

That's it for Constellation.php, it's ready to go.  Now you need to create a class that implements ConstellationDelegate.

ConstellationDelegate
======================

Constellation requires that you provide a delegate for it to call when it needs to determine if it should perform an action.
To that end you will are required to implement the following methods, all of which return a boolean::

	// Read Permission
	function constellationShouldGetForums(Constellation $constellation);
	function constellationShouldGetTopicsForForum(Constellation $constellation, &$forum);
	function constellationShouldGetMessagesForTopic(Constellation $constellation, &$topic);
	function constellationShouldGetMessage(Constellation $constellation, &$message_id);

	// Write Permissions
	function constellationShouldCreateTopic(Constellation $constellation, CNMessage &$message);
	function constellationShouldCreateMessage(Constellation $constellation, CNMessage &$message);

	// Delete Permissions
	function constellationShouldDeleteTopic(Constellation $constellation, &$topic_id);
	function constellationShouldDeleteMessage(Constellation $constellation, CNMessage &$message);

	// TBD Permissions (Filed under Write for now, may change to Admin in the future)
	function constellationShouldUpdateMessage(Constellation $constellation, CNMessage &$message);
	
If you look at ConstellationDelegate.php you will also notice it extends one more interface GalaxyDelegate which requires the following::
	
	function galaxyCachedResponseForCommand(GalaxyApplication $application, $command, $arguments=null);
	function galaxySetCacheForResponse(GalaxyApplication $application, $command, $arguments=null, $response=null);
	
GalaxyDelegate allows for Constellation to ask you if it should load a cache or store a cache before or after an operation.  
:func:`$delegate->galaxyCachedResponseForCommand` is called prior to any GET requests and :func:`$delegate->galaxySetCacheForResponse` is called after any GET request.
POST and PUT requests do not allow for caching.

.. important::
   These delegate calls provide you override points to apply your own user system and permission logic to Constellation operations.  In other words, if you have your own user system,
   Constellation will be able to fit right along side it via these delegate calls.  Is your currently logged in user allowed to post? Allowed to read? Your application logic makes that determination.

