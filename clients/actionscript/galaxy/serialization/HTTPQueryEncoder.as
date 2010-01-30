package galaxy.serialization
{
	import flash.utils.describeType;
	import flash.net.URLVariables;
	
	public class HTTPQueryEncoder
	{
		var variables : URLVariables;
		
		public function HTTPQueryEncoder(value:*)
		{
			variables = new URLVariables();
			if(value is Array ||
			   value is String ||
			   value is Boolean ||
			   value is Number)
			{
				throw new Error("HTTPQueryEncoder can only take an object literal or a custom class");
			}
			else
			{
				http_build_query(value);
			}
		}
		
		private function http_build_query(value:*, prefix:String=null):void
		{
			var nextPrefix : String;
			
			if(value is Array)
			{
				var count : int = value.length;
				for(var i:int = 0; i < count; i++)
				{
					if(value[i] is String ||
					   value[i] is Number ||
					   value[i] is Boolean)
					{
						nextPrefix = prefix+"["+i+"]";
						variables[nextPrefix] = value[i];
					}
					else
					{
						nextPrefix  = prefix+"["+i+"]";
						http_build_query(value[i], nextPrefix);
					}
				}
			}
			else
			{
				var classInfo : XML = describeType( value );
				if ( classInfo.@name.toString() == "Object" )
				{
					
					for (var key:String in value)
					{
						if ( value is Function ) continue;
					
						if(value[key] is String ||
						   value[key] is Number ||
						   value[key] is Boolean)
						{
							nextPrefix = prefix ? prefix+"["+key+"]" : key;
							variables[nextPrefix] = value[key];
						}
						else
						{
							nextPrefix  =  prefix ? prefix+"["+key+"]" : key;
							http_build_query(value[key], nextPrefix);
						}
					}
				}
				else
				{
					
				}
			}
		}
		
		
		/*
		public function httpBuildQuery(value:*):String
		{
			var classInfo : XML = describeType( value );
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

					variables[value] = value[key];
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
						var key:String;
						key = determineKey(value[v.@name])
						
						
						if(value[v.@name] is String ||
						   value[v.@name] is Number ||
						   value[v.@name] is Boolean)
						{
							variables[v.@name.toString()] = value[v.@name]
						}
						else if(value[v.@name] is Object)
						{
							
						}

						//variables.arrayTest = [1,2,3,4];
						//variables[v.@name.toString()] = convertToString(value[v.@name])
					}
				}
			}
		}
		*/
		public function toString():String
		{
			return variables.toString();
		}
		
	}
}