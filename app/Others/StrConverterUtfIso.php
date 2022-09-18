<?php

namespace App\Others;

class StrConverterUtfIso
{
	function __construct()
	{
		# code...
	}

	public static function conver_string_ISO_8859_1_to_UTF_8($str_iso8859_1)
	{
        //ISO 8859-1 to UTF-8
        //$str_utf8 = preg_replace("/([\x80-\xFF])/e", "chr(0xC0|ord('\\1')>>6).chr(0x80|ord('\\1')&0x3F)", $str_iso8859_1);

		$str_utf8 = preg_replace("/([\x80-\xFF])/", "chr(0xC0|ord('\\1')>>6).chr(0x80|ord('\\1')&0x3F)", 
			$str_iso8859_1);

		return $str_utf8;
	}

	public static function conver_string_UTF_8_to_ISO_8859_1($str_utf8)
	{
        /*
        //UTF-8 to ISO 8859-1
        $str_iso8859_1 = preg_replace("/([\xC2\xC3])([\x80-\xBF])/e", "chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)", $str_utf8);
        */

        $str_iso8859_1 = preg_replace("/([\xC2\xC3])([\x80-\xBF])/", "chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)", 
        	$str_utf8);

        return $str_iso8859_1;
    }

}