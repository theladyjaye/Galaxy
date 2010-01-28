package constellation.commands
{
	import galaxy.commands.GalaxyCommand;
	
	public class CNMessages extends GalaxyCommand
	{
		override protected function prepareCommand():void
		{
			method   = GalaxyCommand.GALAXY_METHOD_GET;
			endpoint = 'messages';
		}
	}
}