{
	account:
	{
		map: function(doc)
		{
			if(doc.type == 'channel')
			{
				var channel = doc._id.split('/');
				emit(channel[0], null);
			}
		}
	}
}