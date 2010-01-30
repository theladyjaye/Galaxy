package galaxy.net
{
	import flash.utils.describeType;
	import flash.net.URLVariables;
	
	public function httpBuildQuery(value:*):String
	{
		/*var classInfo:XML = describeType( value );
		var variables = new URLVariables();
		var 
		if ( classInfo.@name.toString() == "Object" )
		{
			for (var key:String in value)
			{
				if ( value is Function )
				{
					continue;
				}
				
				variables[key] = value[key];
			}
		}
		else
		{
			for each ( var v:XML in classInfo..*.( 
				name() == "variable"
				||
				( 
					name() == "accessor"
					// Issue #116 - Make sure accessors are readable
					&& attribute( "access" ).charAt( 0 ) == "r" ) 
				) )
			{
				if ( v.metadata && v.metadata.( @name == "Transient" ).length() > 0 )
				{
					continue;
				}
				
				if(value[v.@name] != null)
				{
					if(value[v.@name] is String ||
					   value[v.@name] is Number ||
					   value[v.@name] is Boolean)
					{
						variables[v.@name.toString()] = value[v.@name]
					}
					else if(value[v.@name] is Object)
					{
						
						//var prefix:String = v.@name.toString()+"_";
					}
					
					//variables.arrayTest = [1,2,3,4];
					//variables[v.@name.toString()] = convertToString(value[v.@name])
				}
			}
		}
		*/
		return ""
	}
}