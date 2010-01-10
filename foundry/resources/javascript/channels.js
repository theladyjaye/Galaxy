$().ready(function(){
	
	var channelContext          = {open:1, closed:2}
	var channelAddContext       = channelContext.closed;
	var channelSubscribeContext = channelContext.closed;
	
	$("#channelSubscribeAction").click(function()
	{
		if(channelAddContext == channelContext.open)
		{
			channelAddContext = channelContext.closed
			$("#channelAddAction").html('+');
			$("#channelFormContext .form").slideUp();
		}
		
		if(channelSubscribeContext == channelContext.closed)
		{
			channelSubscribeContext = channelContext.open
			$("#channelFormContext .formSubscribe").slideDown();
		}
		else if (channelSubscribeContext == channelContext.open)
		{
			channelSubscribeContext = channelContext.closed
			$("#channelFormContext .formSubscribe").slideUp();
		}
		return false;
	});
	
	$("#channelAddAction").click(function()
	{
		if (channelSubscribeContext == channelContext.open)
		{
			channelSubscribeContext = channelContext.closed
			$("#channelFormContext .formSubscribe").slideUp();
		}
		
		if(channelAddContext == channelContext.closed)
		{
			channelAddContext = channelContext.open
			$("#channelAddAction").html('x');
			$("#channelFormContext .form").slideDown();
		}
		else if (channelAddContext == channelContext.open)
		{
			channelAddContext = channelContext.closed
			$("#channelAddAction").html('+');
			$("#channelFormContext .form").slideUp();
		}
		return false;
	});
	
	//$("#channelAddForm").submit(channelAddAction)
});

function channelAddAction()
{
	$(this).ajaxSubmit(function(response)
	{
		/*data = JSON.parse(response);
		if(data.ok == true)
		{
			renegadeDialog.show('Your Account has been updated successfully');
			$("#account").resetForm();
		}
		else if(typeof(data.error) != "undefined")
		{
			renegadeDialog.show('There was an Error...');
		}*/
		
		console.log(response);
	});
	return false;
}
