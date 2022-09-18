<?php 

namespace App\Others;

class ObjectConverter 
{
	function __construct()
	{
		# code...
	}

	public static function getArray($cur_object)
	{
		if (!is_object($cur_object)){
			return $cur_object;
		}

		$arr_value = json_decode(json_encode($cur_object), true);

		return $arr_value;
	}

}