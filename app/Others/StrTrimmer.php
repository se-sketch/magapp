<?php 

namespace App\Others;

use App\Others\ObjectConverter;

class StrTrimmer
{
	protected $str_search;
	protected $str_replace;

	function __construct($str_search, $str_replace)
	{
		$this->str_search = $str_search;
		$this->str_replace = $str_replace;
	}

    public function prepareElement($str_element)
    {
        $str_element = trim($str_element);

        str_replace($this->str_search, $this->str_replace, $str_element);

        return $str_element;
    }

    public function getString($arr_values)
    {
    	$str = '';
    	$cur_str_search = '';

   		$arr_value = [];
    	if (is_array($arr_values)){
    		$arr_value = $arr_values;
    	}elseif(is_object($arr_values)) {
    		$arr_value = ObjectConverter::getArray($arr_values);
    	}else{
    		return '';
    	}    	

    	foreach ($arr_value as $value) {

	   		$str .= $cur_str_search . $this->prepareElement($value);

	   		if (empty($cur_str_search)){
	   			$cur_str_search = $this->str_search;
	   		}
	   	}

    	return $str;
    }

    public function getStringKeys($arr_values, $arr_keys)
    {
    	$str = '';
    	$cur_str_search = '';

    	$arr_value = [];
    	if (is_array($arr_values)){
    		$arr_value = $arr_values;
    	}elseif(is_object($arr_values)) {
    		$arr_value = ObjectConverter::getArray($arr_values);
    	}else{
    		return '';
    	}

    	foreach ($arr_keys as $value) {

    		$element = $arr_value[$value];
    		
    		$str .= $cur_str_search . $this->prepareElement($element);
	   		
	   		if (empty($cur_str_search)){
	   			$cur_str_search = $this->str_search;
	   		}
    	}

    	return $str;
    }

}
