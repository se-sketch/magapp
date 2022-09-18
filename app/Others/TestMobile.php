<?php

namespace App\Others;

class TestMobile
{
	function __construct()
	{
		# code...
	}

    public static function isMobileDevice() 
    {
    	if (array_key_exists("HTTP_USER_AGENT", $_SERVER)){
        	return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    	}

    	return true;
    }

	

}