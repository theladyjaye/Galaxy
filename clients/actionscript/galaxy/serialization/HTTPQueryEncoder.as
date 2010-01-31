package galaxy.serialization
{
	import flash.utils.describeType;
	import flash.net.URLVariables;
	
	public class HTTPQueryEncoder
	{
		public var variables : URLVariables;
		public var delegate  : Object;
		
		public function HTTPQueryEncoder(value:*, delegate:Object=null)
		{
			variables = new URLVariables();
			this.delegate  = delegate;
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
						if(delegate) delegate['encoderWillAddVariableWithKeyAndValue'](this, nextPrefix, value[i]);
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
							if(delegate) delegate['encoderWillAddVariableWithKeyAndValue'](this, nextPrefix, value[key]);
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

						if(value[v.@name] == null) continue;
						
						if(value[v.@name] is String ||
						   value[v.@name] is Number ||
						   value[v.@name] is Boolean)
						{

							nextPrefix = prefix ? prefix+"["+v.@name.toString()+"]" : v.@name.toString();
							if(delegate) delegate['encoderWillAddVariableWithKeyAndValue'](this, nextPrefix, value[v.@name.toString()]);
							variables[nextPrefix] = value[v.@name];
						}
						else
						{
							nextPrefix  =  prefix ? prefix+"["+v.@name.toString()+"]" : v.@name.toString();
							http_build_query(value[v.@name], nextPrefix);
						}
					}
				}
			}
		}
		
		public function toString():String
		{
			return variables.toString();
		}
		
	}
}