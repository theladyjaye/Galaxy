<?php
/**
 * Returns a localized version of a string.
 * The result of invoking Resources::localizedStringForKey($key, $key, null)
 *
 * @param string $key 
 * @return string
 * @author Adam Venturella
 */
function LocalizedStringForKey($key)
{
	return Resources::localizedStringForKey($key, $key);
}
?>