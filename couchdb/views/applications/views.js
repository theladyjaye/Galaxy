{
	account:
	{
		map: function(doc)
		{
			if(doc.type == 'application')
			{
				var application = doc._id.split('/');
				emit(application[0], null);
			}
		}
	}
}