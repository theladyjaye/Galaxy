$().ready(function(){
	
	$("#account").submit(accountAction)
});

function accountAction()
{
	$(this).ajaxSubmit(function(response)
	{
		data = JSON.parse(response);
		if(data.ok == true)
		{
			renegadeDialog.show('Your Account has been updated successfully');
			$("#account").resetForm();
		}
		else if(typeof(data.error) != "undefined")
		{
			renegadeDialog.show('There was an Error...');
		}
	});
	return false;
}
