var renegadeDialog = 
{
	show:function(message)
	{
		if(message)
		{
			$('#dialog .context').html(message);
		}
		
		$('#dialog').slideDown("normal", function()
		{
			renegadeDialog.timer(3.0);
		});
	},
	
	timer:function(time)
	{
		time = time*1000;
		renegadeDialog.timerInterval = setInterval(renegadeDialog.hide, time)
	},
	
	hide:function()
	{
		clearInterval(renegadeDialog.timerInterval);
		$('#dialog').slideUp("normal");
	}
}