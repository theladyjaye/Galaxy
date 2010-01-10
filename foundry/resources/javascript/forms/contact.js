$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); }
});

$().ready(function()
{
	//var form = new BLITZForm("contact");
	//form.addValidator(new BLITZInputLengthValidator('inputMessage', true, 3, null, 'Message Must be at least 3 characters long'));
	//form.addValidator(new BLITZPatternValidator('inputName', /^\D+$/, true, 'Name may only contain letters and must be at least 2 characters long'));
	//form.addValidator(new BLITZEmailValidator('inputEmail', true, 'Invalid e-mail address'));
	//form.addValidator(new BLITZCheckedValidator('inputAgree', true, 'You must agree to continue'));
	
	$("#contact").validate({
			showErrors: formDidFail,
			rules: {
				inputName:  {
					          required:true,
					          minLength:3,
					          maxLength:5
					        },
				inputEmail: {
					          required: true,
					          email: true
				            },
				inputAgree: "required"
			},
			messages: {
				email: "Please enter a valid email address",
				agree: "Please accept our policy"
			}
		});
	
	function formDidFail(errorMap, errorList)
	{
		//alert('Fail!');
	}
	/*form.formWillSubmit = function(form)
	{
	}
	
	form.formDidComplete = function(form, response)
	{
		$("#form").fadeOut();
		$("#response").html(response);
		$("#response").fadeIn();
	}
	
	form.formDidFail = function(form, validators)
	{
		var response = "";
		var count    = validators.length;
		
		for(var i = 0; i < count; i++)
		{
			
			if(validators[i].isValid == false)
			{
				//form.elements[validators[i].key].css('background-color', '#ff9898');
				response = response += "<div class=\"form-error\">"+validators[i].message+"</div>";
			}
			else
			{
				//form.elements[validators[i].key].css('background-color', '#ffffff');
			}
		}
		$("#errors").html(response);
	}*/
});