*****************
Requirements
*****************

Galaxy Responses
================
Galaxy will respond to all requests in JSON.  Additional formats may become available, but for right now only JSON is supported


PHP, etc...
============
PHP 5.2.x is required to use Constellation.  Additionally, :func:`json_encode`/ :func:`json_decode` must be enabled.
Network requests are made using :func:`stream_socket_client`.