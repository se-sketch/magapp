<?php

namespace App\Others;

class StrEscaper
{
	function __construct()
	{
		# code...
	}

    public static function getEscapedString(string $string)
    {
        /**
        * Returns a string with backslashes before characters that need to be escaped.
        * As required by MySQL and suitable for multi-byte character sets
        * Characters encoded are NUL (ASCII 0), \n, \r, \, ', ", and ctrl-Z.
        * In addition, the special control characters % and _ are also escaped,
        * suitable for all statements, but especially suitable for `LIKE`.
        *
        * @param string $string String to add slashes to
        * @return $string with `\` prepended to reserved characters
        *
        * @author Trevor Herselman
        */
        if (function_exists('mb_ereg_replace'))
        {
            
            return mb_ereg_replace('[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]', '\\\0', $string);

            /*
            function mb_escape(string $string)
            {
                return mb_ereg_replace('[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]', '\\\0', $string);
            }
            */

        } else {

            return preg_replace('~[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]~u', '\\\$0', $string);

            /*
            function mb_escape(string $string)
            {
                return preg_replace('~[\x00\x0A\x0D\x1A\x22\x25\x27\x5C\x5F]~u', '\\\$0', $string);
            }
            */
        }

        return '';
    }
	

}