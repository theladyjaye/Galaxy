var signupVerify = {email:false, name:false};
var signupSubmit = false;

$().ready(function(){
	
	$("#signupModal #signupForm").submit(signupAction)
	
	/*$("#signupForm #inputName").blur(function(){
		
		//console.log('verifying name: '+$(this).val())
		signupVerify.name = true;
		
		var action = '/';
		var params = {}
		
		$.post(action, params, function(response){
			//console.log('verify name complete!');
			signupVerify.name = false;
			
			if(signupSubmit)
			{
				signupAction();
			}
		})
	});
	*/
	
	/*$("#signupForm #inputEmail").blur(function(){
		$(this).val();
		//console.log('verifying email: '+$(this).val())
		
		var action = '/';
		var params = {}
		
		signupVerify.email = true;
		
		$.post(action, params, function(response){
			//console.log('verify e-mail complete!');
			signupVerify.email = false;
			
			if(signupSubmit)
			{
				signupAction();
			}
		})
	});
	*/
	
	
	$("#signupModal .close .action").click(function(){
		$('#signupModal').hide();
		return false;
	});
	
	$("#actionSignup").click(function(){
		$('#signupModal').show();
		return false;
	});
	
});

function signupAction()
{
	signupSubmit = true;

	if(signupVerify.name || signupVerify.email)
	{
		//console.log('Waiting...');
	}
	else
	{
		$(this).ajaxSubmit(function(response){
			signupSubmit = false;
			renegadeDialog.show();
			console.log(response);
		});
	}
	return false;
}
