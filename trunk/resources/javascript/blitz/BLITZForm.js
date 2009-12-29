
function BLITZForm(id)
{
	var object        = $("form#"+id);
	var validators    = [];
	this.id           = id;
	this.isAvailable  = true;
	this.elements     = {}
	this.texts        = null;
	this.selects      = null;
	this.checkboxes   = null;
	this.isValid      = true;
	
	this.addValidator = function(validator)
	{
		validator.form = this;
		validators.push(validator)
	}
	
	this.validateForm = function()
	{
		var length  = validators.length
		var tmpFlag = true;
		
		for(var i = 0; i < length; i++ )
		{
			var currentValidator = validators[i];
			currentValidator.validate();
			
			if(currentValidator.isRequired)
				tmpFlag = (tmpFlag && currentValidator.isValid);
		}
		
		if(tmpFlag != this.isValid)
			this.isValid = tmpFlag;
	}
	
	
	this.params = function()
	{
		this.elements = {}
	
		var params    = {}
		var form      = "form#"+id;
		var scope     = this;
		
		// 1.3 failes in : Firefox 3.5.2 & jQuery 1.3.2
		//var checkboxes = $(form+" input[type=checkbox][checked]");
		
		this.checkboxes = $(form+" input[type=checkbox]");
		this.texts      = $(form+" input[type=text], input[type=password], textarea");
		this.selects    = $(form+" select");
		
		scope.texts.each(function()
		{
			var key             = $(this).attr("name");
			scope.elements[key] = $(this)
			params[key]         = $(this).val();
		});
	
		scope.checkboxes.each(function()
		{
			var key = $(this).attr("name");
			
			if(typeof(scope.elements[key]) != "undefined")
			{
				if(scope.elements[key] instanceof Array )
				{
					scope.elements[key].push($(this))
				}
				else
				{
					scope.elements[key] = [scope.elements[key], $(this)];
				}
			}
			else
			{
				scope.elements[key] = $(this)
			}
			
			
			if($(this).is(':checked')){
				params[key] = $(this).val();
			}
		});
		
		
		scope.selects.each(function(){
			var key             = $(this).attr("name");
			scope.elements[key] = $(this)
			params[key]         = $(this).val();
		});
		
		return params
	}
	
	this.complete = function()
	{
		var scope = this;
		
		return function(response)
		{
			scope.isAvailable = true;
			scope.formDidComplete(scope, response)
		}
	}
	
	this.submit = function()
	{
		var scope    = this;
		
		return function()
		{
			if(scope.isAvailable)
			{
				scope.isAvailable = false;
				var params = scope.params();
				scope.validateForm();
				
				if(scope.isValid)
				{
					var method = object.attr("method").toLowerCase();
					var action = object.attr("action");
					
					scope.formWillSubmit(scope);
				
					switch(method)
					{
						case "get":
							$.get(action, params, scope.complete())
							break;

						case "post":
							$.post(action, params, scope.complete())
							break;
					}
				}
				else
				{
					scope.formDidFail(scope, validators)
					scope.isAvailable = true;
				}
			}
			else
			{
				// form is not available, probably gettign it's submit on, chill
			}
		
			return false;
		}
	}
	
	// delegate methods
	this.formDidComplete = function(form, response) {};
	this.formWillSubmit  = function(form) {};
	this.formDidFail     = function(form, validators) {};
	
	object.submit(this.submit());
	
	return true;
}
