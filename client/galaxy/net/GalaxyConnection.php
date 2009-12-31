<?php
class GalaxyConnection
{
	private $host         = 'api.renegade.com';
	private $port         = '80';
	private $transport    = 'tcp://';
	private $timeout      = 10;
	private $agent        = 'GalaxyClient/{version} (PHP)';
	private $scheme       = 'http://';
	private $command;
	private $options;
	
	public static function initWithCommandAndOptions(GalaxyCommand $command, $options)
	{
		$connection          = new GalaxyConnection();
		$connection->command = $command;
		$connection->options = $options;
		$connection->agent   = str_replace('{version}', Galaxy::kVersion, $connection->agent);
		return $connection;
	}
	
	final public function requestWithCommand($command)
	{
		$format        = $this->options['format'];
		
		// an alternate option is OAuth WRAP. We dont' have any support for it
		// as of yet, but we want the code paths to hint that we might down the line.
		if($this->options['authorization']['type'] == Galaxy::kAuthorizationOAuth)
		{
			$authorization = new GalaxySignatureOAuth();
			$authorization->setKey($this->options['authorization']['key']);
			$authorization->setSecret($this->options['authorization']['secret']);
			$authorization->setMethod($command->method);
			$authorization->setRealm(Galaxy::kSchemeGalaxy.$this->options['id']);
			
			// NOTE: We add the leading slash for the command action.  Command actions should not start with the /
			$authorization->setAbsoluteUrl($this->scheme.$this->host.'/'.$command->action);
			
			$authorization = (string) $authorization;
		}
		
		// NOTE: We add the leading slash for the action.  Actions should not start with the /
		return <<<REQUEST
$command->method /$command->action HTTP/1.0
$authorization
Host: $this->host:$this->port
User-Agent: $this->agent
Accept: $format
Connection: Close


REQUEST;
	}
	
	public function start()
	{
		$request = $this->requestWithCommand($this->command);
		$data = $this->connect($request);
		
		$response = GalaxyResponse::responseWithData($data);
		
		if($response->error)
		{
			throw new Exception((string) $command.' Failed with error '.$response->error['error'].': '.$response->error['reason']);
		}
		return $response;
	}
	
	private function connect($request)
	{
		$errno    = null;
		$errstr   = null;
		$response = null;

		$socket  = $this->transport.$this->host.':'.$this->port;
		$stream  = stream_socket_client($socket, $errno, $errstr, $this->timeout);

		if(!$stream)
		{
			throw new Exception('GalaxyClient unable to connect to host '.$socket.' : '.$errno.', '.$errstr);
			return;
		}
		else
		{
			fwrite($stream, $request);
			$response = stream_get_contents($stream);
			fclose($stream);
			return $response;
		}

		fclose($stream);
	}
}
?>