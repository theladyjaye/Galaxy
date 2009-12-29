<?php
class Resources
{
	/**
	 * Returns a localized version of the string designated by a given key in a given table
	 * this function is based on the behavior of {@link http://devworld.apple.com/documentation/Cocoa/Reference/Foundation/Classes/NSBundle_Class/Reference/Reference.html#//apple_ref/occ/instm/NSBundle/localizedStringForKey:value:table: Cocoa Equilivant}
	 * 
	 * @param string $key optional The key for a string in the table identified by tableName
	 * @param string $value optional The value to return if key is null or if a localized string for key can’t be found in the table.
	 * @param string $table optional The receiver’s string table to search. If tableName is null or is an empty string, the method attempts to use the table in Localizable.strings
	 * @return string
	 * @author Adam Venturella
	 */
	public static function localizedStringForKey($key=null, $value=null, $tableName=null)
	{
		static $dictionary = array();
		static $language;
		
		if(!$key && !$value)
		{
			return "";
		}
		else
		{
			if(!$language)
			{
				$lang    = Application::current_language();
				$lang    = explode('_', $lang);
				$lang    = strtolower($lang[0]);
				$language = $lang;
				unset($lang);
			}
			
			$tableName   = $tableName ? $tableName : 'Localizable'; 
			
			if(!isset($dictionary[$tableName]))
			{
				$path    = $_SERVER['DOCUMENT_ROOT'].Configuration::kResourcePath.$language."/".$tableName.".strings";
				
				if(file_exists($path))
				{
					$strings = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				
					$dictionary[$tableName] = array();
				
					foreach($strings as $string)
					{
						if(strpos($string, '//') !== 0)
						{
							list($k, $v) = explode('=', $string);
							$dictionary[$tableName][trim($k)] = trim($v);
						}
					}
				}
			}
			
			$response = isset($dictionary[$tableName][$key]) ? $dictionary[$tableName][$key] : null;
			
			if(!empty($response))
			{
				return $response;
			}
			else
			{
				if($value)
				{
					return $value;
				}
				else if($key)
				{
					return $key;
				}
				else 
				{
					return "";
				}
			}
		}
	}
}
?>