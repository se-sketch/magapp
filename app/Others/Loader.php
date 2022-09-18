<?php 

namespace App\Others;

class Loader
{
	function __construct()
	{
		# code...
	}

    public static function downloadFile($filename)
    {
        if (empty($filename)){
            //exit('file empty: '.$filename);
        }
        if (!file_exists($filename)) {
            //exit('file does not exists: '.$filename);
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    }	


}