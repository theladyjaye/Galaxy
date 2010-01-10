$(document).ready(function(){
	$('.channelDelete').click(function(){
		
		var target = ($(this).attr('href'));
		var parts  = target.split('/');
		var params = {id: parts[0]};
	
		$.post('/account/channels/delete/', params, function(response) {
			if(response == 1)
			{
				$("#"+parts[0]).remove();
			}
		});
		
		return false;
	});
});

