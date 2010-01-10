function BLITZValidator()
{
	this.key           = null;
	this.form          = null;
	this.isRequired    = false;
	this.shouldRequire = false;
	this.isValid       = false;
	this.message       = null;
	this.validate      = function() { /* pass */ }
	
	this.updateRequiredFlag = function(value)
	{
		if(value.length > 0 && this.shouldRequire)
		{
			this.isRequired = true;
		}
		else
		{
			this.isRequired = this.shouldRequire ? false : true;
		}
	}
}

BLITZInputLengthValidator.prototype             = new BLITZValidator;
BLITZInputLengthValidator.prototype.constructor = BLITZInputLengthValidator;
function BLITZInputLengthValidator(name, required, minLength, maxLength, message)
{
	this.key           = name;
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	this.minLength     = minLength;
	this.maxLength     = maxLength;
	
	this.validate = function()
	{
		this.isValid = false;
		var value    = this.form.elements[this.key].val()
		this.updateRequiredFlag(value)
		
		if(this.minLength)
		{
			if(value.length < this.minLength)
			{
				this.isValid  = false;
				return;
			}
			else
			{
				this.isValid = true;
			}
		}
		
		if(this.maxLength)
		{
			if(value.length <= this.maxLength)
			{
				this.isValid  = true;
			}
			else
			{
				this.isValid = false;
				return;
			}
		}
	}
}

BLITZZipCodeValidator.prototype             = new BLITZValidator;
BLITZZipCodeValidator.prototype.constructor = BLITZZipCodeValidator;
function BLITZZipCodeValidator(name, required, message)
{
	this.key           = name;
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	
	this.validate = function()
	{
		this.isValid = false;
		var pattern  = /^\d{5}([\-]\d{4})?$/;
		var value    = this.form.elements[this.key].val()

		this.updateRequiredFlag(value);
		this.isValid = value.match(pattern) == null ? false : true;
	}
	
	return true;
}

BLITZMatchValidator.prototype             = new BLITZValidator;
BLITZMatchValidator.prototype.constructor = BLITZMatchValidator;
function BLITZMatchValidator(name1, name2, required, message)
{
	this.key           = [name1, name2];
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	
	this.validate = function()
	{
		this.isValid = false;
		var value1   = this.form.elements[this.key[0]].val()
		var value2   = this.form.elements[this.key[1]].val()
		
		if((value1.length > 0  || value2.length > 0) && this.shouldRequire)
		{
			this.isRequired = true;
		}
		else
		{
			this.isRequired = this.shouldRequire ? false : true;
		}
		
		if(value1 == value2)
		{
			this.isValid = true;
		}
	}
	
	return true;
}

BLITZEmailValidator.prototype             = new BLITZValidator;
BLITZEmailValidator.prototype.constructor = BLITZEmailValidator;
function BLITZEmailValidator(name, required, message)
{
	this.key           = name;
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	
	this.validate = function()
	{
		this.isValid = false;
		var pattern       = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		var value    = this.form.elements[this.key].val()

		this.updateRequiredFlag(value);
		
		this.isValid = value.match(pattern) == null ? false : true;
	}
	
	return true;
}

BLITZCheckedValidator.prototype             = new BLITZValidator;
BLITZCheckedValidator.prototype.constructor = BLITZCheckedValidator;
function BLITZCheckedValidator(name, required, message)
{
	this.key           = name;
	this.message       = message;
	this.isRequired    = required;
	
	this.validate = function()
	{
		this.isValid = this.form.elements[this.key].is(':checked')
	}
	
	return true;
}

BLITZPatternValidator.prototype             = new BLITZValidator;
BLITZPatternValidator.prototype.constructor = BLITZPatternValidator;
function BLITZPatternValidator(name, required, pattern, message)
{
	this.key           = name;
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	this.pattern       = pattern;
	
	this.validate = function()
	{
		this.isValid = false;
		var value    = this.form.elements[this.key].val()
		
		this.updateRequiredFlag(value);
		this.isValid = value.match(pattern) == null ? false : true;
	}
	
	return true;
}

BLITZCustomValidator.prototype             = new BLITZValidator;
BLITZCustomValidator.prototype.constructor = BLITZCustomValidator;
function BLITZCustomValidator(names, required, func, message)
{
	this.key           = names;
	this.message       = message;
	this.isRequired    = required;
	this.shouldRequire = required ? false : true;
	this.func          = func;
	
	this.validate = function()
	{
		this.isValid = this.func(this)
	}
	
	return true;
}
