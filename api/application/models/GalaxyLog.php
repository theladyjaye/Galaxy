<?php
class GalaxyLog
{
	private $endpoint;
	private $context;
	private $method;
	
	public function setMethod($value)
	{
		$this->method = $value;
	}
	public function setEndpoint($value)
	{
		$this->endpoint = $value;
	}
	
	public function setContext(GalaxyContext $value)
	{
		$this->context = $value;
	}
	
	public function write()
	{
		/*$application_id = GalaxyAPI::applicationIdForChannelId($this->context->channel);
		$options        = array('default' => GalaxyAPI::databaseForId($application_id));
		$db_channels    = GalaxyAPI::database(GalaxyAPIConstants::kDatabaseMongoDB, GalaxyAPIConstants::kDatabaseLog, $options);
		$db_channels->update(array('_id'=>"$this->context->channel"), array('$inc'=>array('requests'=>1)));
		*/
		print_r($this->context);
	}
}
?>