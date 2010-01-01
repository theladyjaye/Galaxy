<?php
require 'GalaxyApplication.php';
class GalaxyForum extends GalaxyApplication
{
	public function topics_post($data)
	{
		
	}
	
	public function topics_delete($data)
	{
		
	}
	
	public function topics_put($data)
	{
		
	}
	
	public function topics_get($channel)
	{
		$options  = array('default' => GalaxyAPI::databaseForId($application));
		$channels = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, GalaxyAPIConstants::kDatabaseChannels, $options);
		$result   = $channels->find();
		$data     = array();
		
		foreach($result as $channel)
		{
			$data[] = array('id'          => $channel['_id'],
			                'type'        => $channel['type'],
			                'description' => $channel['description']);
		}
		
		return GalaxyResponse::responseWithData($data);
	}
}
?>