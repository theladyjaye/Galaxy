package constellation
{
	import constellation.models.CNMessage;
	public interface IConstellationDelegate
	{
		function constellationShouldGetForums(cn:Constellation):Boolean;
		function constellationShouldGetTopicsForForum(cn:Constellation, forum:String):Boolean;
		function constellationShouldGetMessagesForTopic(cn:Constellation, topic:String):Boolean;
		
		function constellationShouldCreateMessage(cn:Constellation, message:CNMessage):Boolean;
		function constellationShouldCreateTopic(cn:Constellation, message:CNMessage):Boolean;
	}
}