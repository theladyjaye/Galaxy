<?php
require 'CouchDBProxy.php';

// all requests need to get the allowed db based on the domain token
// if that db is not present, then GET/HEAD/POST/PUT are not allowed


$allowed = false;
$verb    = strtolower($_SERVER['REQUEST_METHOD']);

switch($verb)
{
	case 'post':
		$allowed = shouldAllowPost($_SERVER['REQUEST_URI']);
		break;
	
	case 'put':
		$allowed = shouldAllowPut($_SERVER['REQUEST_URI']);
		break;
	
	case 'get':
	case 'head':
		$allowed = true;
		break;
}

if($allowed)
{
	$proxy = new CouchDBProxy('127.0.0.1', '5984');
	$proxy->proxy();
}

function shouldAllowPut($uri)
{
	$result = false;
	// the only PUT allowed looks like this:
	// PUT /renegade/_local%2F7f3c9857081d82440554686a50affe2d HTTP/1.1\r\n
	// we can also check the JSON document in php://input to ensure it conforms properly to :
	// {"_id":"_local/7f3c9857081d82440554686a50affe2d","_rev":"0-3","session_id":"d5b2c06d983794ba6578324ca827d007","source_last_seq":148,"history":[{"session_id":"d5b2c06d983794ba6578324ca827d007","start_time":"Mon, 19 Oct 2009 00:32:13 GMT","end_time":"Mon, 19 Oct 2009 00:32:16 GMT","start_last_seq":0,"end_last_seq":148,"recorded_seq":148,"missing_checked":0,"missing_found":38,"docs_read":42,"docs_written":42,"doc_write_failures":0}]}
	if(strpos($uri, '_local') !== false)
	{
		$result = true;
	}
	
	return $result;
}

function shouldAllowPost($uri)
{
	$result = false;
	
	// the only POST allowed looks like this:
	// POST /renegade/_ensure_full_commit?seq=148 HTTP/1.1\r\n
	// get the database that is allowed for replication here based on the token
	// so we can make this strpos: /<dbname>/_ensure_full_commit?seq
	
	if(strpos($uri, '_ensure_full_commit?seq') !== false)
	{
		$result = true;
	}
	return $result;
}
?>