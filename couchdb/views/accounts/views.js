{
	email:
	{
		map: function(doc)
		{
			if(doc.type == 'user')
			{
				emit(doc.email, null);
			}
		}
	}
}