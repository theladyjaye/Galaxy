package constellation.commands
{
	import galaxy.commands.GalaxyCommand;
	
	public class CNMessageUpdate extends GalaxyCommand
	{
		override protected function prepareCommand():void
		{
			method   = GalaxyCommand.GALAXY_METHOD_POST;
			endpoint = 'messages';
		}
	}
}