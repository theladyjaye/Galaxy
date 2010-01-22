********************************
Constellation Command Reference
********************************

.. module:: Constellation
   :synopsis: Implementation of the Constellation API.


Constellation Objects
---------------------

.. class:: __construct()

   Designated Constellation initializer.  All responses are returned as JSON.


   .. method:: forum_list()

      Retrieves list of available forums.  Returns an array of the following JSON Objects:
      Sample Response::
	{"ok":true,
	 "response":[{"id":"com.galaxy.community.announcements-general",
	              "type":"channel",
	              "label":"Galaxy Announcements",
	              "description":"Announcements about the Galaxy Platform",
	              "source":{"id":"com.galaxy.community",
	                        "description":"Galaxy Community",
	                        "domain":"galaxy"},
	              "requests":386}
	            ]
	}


   .. method:: message($id)

      Get a single message with the given id.  Returns a single JSON object.
      Response Sample::
	{"ok":true,
	 "response":{"_id":"4b5945928ead0e8501030000",
	             "title":"Hello World",
	             "body":"This is a test",
	             "author":{"name":"GodMoose",
	                       "avatar_url":"http:\/\/www.gravatar.com\/avatar\/1a6b4b96e9933a0259babb3a9d02f759.png"},
	             "source":{"id":"com.galaxy.community",
	                       "description":"Galaxy Community",
	                       "domain":"galaxy"},
	             "topic":"4b5945928ead0e8501020000",
	             "topic_origin":true,
	             "created":"2010-01-21T22:28:34-0800",
	             "type":"message",
	             "requests":2}
	}

      In the object, *topic_origin* will be true|false based on weather or not it was the message that is responsible for spawning the topic.


   .. method:: message_new(CNMessage $message)

      Reply to a topic with given CNMessage Model object


   .. method:: message_update(CNMessage $message)

      Update and existing message with the data in a given CNMessage model object


   .. method:: message_delete(CNMessage $message)

      Delete a message matching $message->context


   .. method:: topic_delete($topic_id)

      Delete a topic for a given id


   .. method:: topic_list($forum, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)

      Given a forum id (Channel Id) will return topics for that forum.  Returns an array of JSON objects.
      Sample Response::

	{"ok":true,
	 "response":[{"id":"4b57ad8b8ead0e7706030000",
	              "requests":9,
	              "replies":2,
	              "title":"Hello World",
	              "author":{"name":"logix812",
	                        "avatar_url":"http:\/\/www.gravatar.com\/avatar\/1a6b4b96e9933a0259babb3a9d02f759.png"},
	              "source":{"id":"com.galaxy.community",
	                        "description":"Galaxy Community",
	                        "domain":"galaxy"},
	              "last_message":{"id":"4b57aebe8ead0e7806060000",
	                              "source":{"id":"com.galaxy.community",
	                                        "description":"Galaxy Community",
	                                        "domain":"galaxy"},
	                              "author":{"name":"GodMoose",
	                                        "avatar_url":"http:\/\/www.gravatar.com\/avatar\/1a6b4b96e9933a0259babb3a9d02f759.png"},
	                                        "created":"2010-01-20T17:32:46-0800"},
	                              "created":"2010-01-20T17:27:39-0800",
	              "type":"topic"}
	            ]
	}


   .. method:: topic_messages($topic, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)

      Retrieve a list of messages for a given topic.  Returns an array of JSON objects.
      Sample Response::

	{"ok":true
	 "response":[{"id":"4b5945928ead0e8501030000",
	              "title":"Hello World",
	              "body":"This is a test",
	              "author":{"name":"GodMoose",
	                        "avatar_url":"http:\/\/www.gravatar.com\/avatar\/1a6b4b96e9933a0259babb3a9d02f759.png"},
	              "source":{"id":"com.galaxy.community",
	                        "description":"Galaxy Community",
	                        "domain":"galaxy"},
	              "created":"2010-01-21T22:28:34-0800",
	              "type":"message"}
	            ]
	}


   .. method:: topic_new(CNMessage $message)

      Creates a new topic with a give CNMessage model object


.. module:: CNAuthor
   :synopsis: Object representing the author of a message

CNAuthor Objects
-----------------

.. class:: __construct()

   Designated CNAuthor initializer


   .. method:: data()

      returns the array representation of the object


   .. method:: setAvatarUrl($value)

      Sets the absolute url to the authors avatar


   .. method:: setName($value)

      Set the name of the author


.. module:: CNMessage
   :synopsis: Object representing the contents of a message

CNMessage Objects
-----------------

.. class:: __construct()

   Designated CNMessage initializer


   .. method:: data()

      returns the array representation of the object


   .. method:: setBody($value)

      Sets the body of the message


   .. method:: setTitle($value)

      Sets the title of the message
