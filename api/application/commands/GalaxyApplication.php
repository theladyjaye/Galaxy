<?php
abstract class GalaxyApplication
{
	public function channels_get(GalaxyContext $context)
	{
		$options  = array('default' => GalaxyAPI::databaseForId($context->application));
		$channels = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, GalaxyAPIConstants::kDatabaseChannels, $options);
		$result   = $channels->find();
		$data     = array();
		
		foreach($result as $channel)
		{
			$data[] = array('id'                 => $channel['_id'],
			                'type'               => $channel['type'],
			                'label'              => $channel['label'],
			                'description'        => $channel['description'],
			                'origin'             => $context->origin,
			                'origin_description' => $context->origin_description,
			                'origin_domain'      => $context->origin_domain);
		}
		
		return GalaxyResponse::responseWithData($data);
	}
}
?>