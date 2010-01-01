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
		$format         = $this->options['format'];
		$endpoint       = $this->prepare_endpoint($command);
		$content        = null;
		$header_content = null;
		
		if($command->method != GalaxyCommand::kMethodGet && !empty($command->content))
		{
			if(is_array($command->content))
			{
				$content        = http_build_query($command->content);
				$content_type   = 'application/x-www-form-urlencoded';
				$content_length = strlen($content);
			}
			else
			{
				$content        = $command->content;
				$content_type   = $command->content_type;
				$content_length = strlen($content);
			}
			
			$header_content = "\r\nContent-Type: $content_type\r\nContent-Length: $content_length";
			
			$content = "\r\n".$content;
		}

		// an alternate option is OAuth WRAP. We dont' have any support for it
		// as of yet, but we want the code paths to hint that we might down the line.
		if($this->options['authorization']['type'] == Galaxy::kAuthorizationOAuth)
		{
			$authorization = new GalaxySignatureOAuth();
			$authorization->setKey($this->options['authorization']['key']);
			$authorization->setSecret($this->options['authorization']['secret']);
			$authorization->setMethod($command->method);
			$authorization->setAdditionalParameters($command->content);
			$authorization->setRealm(Galaxy::kSchemeGalaxy.$this->options['id']);
			
			// NOTE: We add the leading slash for the command action.  Command endpoints should not start with the /
			$authorization->setAbsoluteUrl($this->scheme.$this->host.'/'.$command->endpoint);
			
			$authorization = (string) $authorization;
		}
		
		
		// NOTE: We add the leading slash for the action.  Actions should not start with the /
		return <<<REQUEST
$command->method /$endpoint HTTP/1.0
$authorization
Host: $this->host:$this->port
User-Agent: $this->agent
Accept: $format{$header_content}
Connection: Close

$content
REQUEST;
	}
	
	private function prepare_endpoint(GalaxyCommand $command)
	{
		$endpoint = $command->endpoint;
		
		if(!empty($command->data) && $command->method == GalaxyCommand::kMethodGet)
		{
			$endpoint = $endpoint.'?'.http_build_query($command->data);
		}
		
		return $endpoint;
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

		$socket   = $this->transport.$this->host.':'.$this->port;
		$stream   = stream_socket_client($socket, $errno, $errstr, $this->timeout);

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