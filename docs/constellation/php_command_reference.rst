********************************
Constellation Command Reference
********************************

.. module:: Constellation
   :synopsis: Implementation of the Constellation API.


Constellation Objects
---------------------

.. class:: __construct()

   Designated Constellation initializer


   .. method:: forum_list()

      Retrieves list of available forums


   .. method:: message($id)

      Get a single message with the given id


   .. method:: message_new(CNMessage $message)

      Reply to a topic with given CNMessage Model object


   .. method:: message_update(CNMessage $message)

      Update and existing message with the data in a given CNMessage model object


   .. method:: message_delete(CNMessage $message)

      Delete a message matching $message->context


   .. method:: topic_delete($topic_id)

      Delete a topic for a given id


   .. method:: topic_list($forum, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)

      Given a forum id (Channel Id) will return topics for that forum


   .. method topic_messages($topic, $page=Galaxy::kDefaultPage, $limit=Galaxy::kDefaultLimit)

      Retrieve a list of messages for a given topic


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
