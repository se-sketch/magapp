<?php

namespace App\Others;

class StrArrayExport extends StrTrimmer
{
	protected $array_export;
	
	function __construct(Array $array_export, $str_search, $str_replace)
	{
		$this->array_export = $array_export;
		$this->str_search = $str_search;
		$this->str_replace = $str_replace;
	}

	public function getContent($array_export)
	{
		if (!is_array($array_export)){
			exit(var_dump($array_export));
		}

		$str = '';

		foreach ($array_export as $key => $value) {

			if (is_array($value)){
				$str .= $this->getContent($value);
			}else{
				$str_element = $this->prepareElement($value);
				
				if (empty($str)){
					$str = $str_element;
				}else{
					$str .= $this->str_search . $str_element;
				}
			}
		}

		return $str.PHP_EOL;
	}

	public function getDataExport()
	{
		$str_content = $this->getContent($this->array_export);

		return $str_content;
	}

}