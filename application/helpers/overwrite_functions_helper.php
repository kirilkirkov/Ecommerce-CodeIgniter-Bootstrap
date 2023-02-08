<?php 

/**
 * This file is use to rewrite CI functions for adapters which application
 */

 if ( ! function_exists('lang'))
{
	/**
	 * Lang
	 *
	 * This function changes CI's native behavior somewhat. 
     * Instead of returning FALSE when the translation is unavailable, 
     * return the string we were trying to translate. 
     * This allows you to have text instead of an empty space on the screen 
     * and helps to quickly spot untranslated text 
	 *
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function lang($line, $for = '', $attributes = array())
	{
		$translation = get_instance()->lang->line($line);

        if ($translation === FALSE)
        {
            $translation = $line;
        }

		if ($for !== '')
		{
			$translation = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$translation.'</label>';
		}

		return $translation;
	}
}