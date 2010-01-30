package constellation.commands
{
	import galaxy.commands.GalaxyCommand;
	
	public class CNMessageNew extends GalaxyCommand
	{
		override protected function prepareCommand():void
		{
			method   = GalaxyCommand.GALAXY_METHOD_PUT;
			endpoint = 'messages';
		}
	}
}