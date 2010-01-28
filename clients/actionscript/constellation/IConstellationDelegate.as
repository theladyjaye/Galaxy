package constellation
{
	public interface IConstellationDelegate
	{
		function constellationShouldGetForums(cn:Constellation):Boolean;
		function constellationShouldGetTopicsForForum(cn:Constellation, forum:String):Boolean;
		function constellationShouldGetMessagesForTopic(cn:Constellation, topic:String):Boolean;
	}
}