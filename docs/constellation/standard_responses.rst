.. standard_responses:

********************************************
Standard API Responses
********************************************
The Galaxy API will return the following standardized responses across application types:

- Unauthorized
- Errors
- Success

Unauthorized
------------
If a request you make is not allowed you will receive a *401 Unauthorized* in response to your request.


Errors
------
Errors received from API requests will be in the following JSON format::

	{"ok":false,
	 "type":"error",
	 "errors":[{"reason":"why it went wrong 1"}, 
	           {"reason":"why it went wrong 2"}]
	}
	

Success
-------
Success messages may come in different forms depending on the data you would like to receive, however, you will be able to rely
on "ok" and "response" being present in the top level of the returned object::
	
	{"ok":true,
	 "response":"varies depending on request"
	} 
	

The "response" property will contain any request related data, e.g.,
All GET request will have a "response" property with their associated data where as POST, PUT, DELETE, etc request my contain an empty response.
See the documentation related to your specific application for expected responses.


