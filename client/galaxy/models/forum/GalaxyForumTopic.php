<?php
class GalaxyForumTopic
{
	private $subject;
	private $message;
	
	public static function topicWithSubjectAndMessage($subject, $message)
	{
		$topic = new GalaxyForumTopic();
		$topic->subject = $subject;
		$topic->message = $message;
		return $topic;
	}
	
	public function data()
	{
		return array('subject' => $this->subject,
		             'message' => $this->message);
	}
}
?>