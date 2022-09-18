<?php 

namespace App\Others;

class XmlArrayToXml
{
	private $array_export;
	
	function __construct(Array $array_export)
	{
		$this->array_export = $array_export;
	}

	private function getFileName()
	{
        $filename = 'temp/'. trim(date('Y-m-d_H-i')).'.xml';

        return $filename;
	}

    private function arraytoxml($dom, $root, $array_export)
    {
        foreach ($array_export as $key => $value) {
            
            if (is_array($value)){

                $name = is_integer($key) ? 'element' : trim($key);
                
                $elements_node = $dom->createElement($name);
                $root->appendChild($elements_node);
                $this->arraytoxml($dom, $elements_node, $value);

            }else{
                $attr = new \DOMAttr($key, $value);
                $root->setAttributeNode($attr);
            }
        }        
    }

    public function getFile()
    {
        $xml_file_name = $this->getFileName();

        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';
        $dom->formatOutput = true;

        $root = $dom->createElement('root');

        $this->arraytoxml($dom, $root, $this->array_export);

        $dom->appendChild($root);

        $dom->save($xml_file_name);

        return $xml_file_name;
    }

}