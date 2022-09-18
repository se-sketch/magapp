<?php 

namespace App\Others;

use Illuminate\Support\Facades\DB;
use App\Others\StrTrimmer;

class OrdersRegionsCsv
{
    protected $svodnaya_id;
	
	function __construct($svodnaya_id)
	{
        $svodnaya_id = (int) $svodnaya_id;

		$this->svodnaya_id = ($svodnaya_id > 0) ? $svodnaya_id : null;
	}

    public function getFileName()
    {
        $filename = "maps_".date("Y-m-d_H-i").".csv";
        if ($this->svodnaya_id > 0){
            $filename = "svmaps_".$this->svodnaya_id.".csv";
        }
        
        return $filename;
    }

    public function getTable()
    {
        $table = DB::table('details')
        ->leftJoin('orders', 'details.order_id', '=', 'orders.id')
        ->leftJoin('settlements', 'orders.settlement_id', '=', 'settlements.id')
        ->leftJoin('regions', 'settlements.region_id', '=', 'regions.id')
        ->leftJoin('areas', 'regions.area_id', '=', 'areas.id')
        ->select('settlements.latitude', 'settlements.longitude', 'settlements.name', 
            'areas.name as area', 'regions.name as region')
        ->selectRaw('sum(details.qty) as qty')
        ->where('details.deleted_at', null)
        ->where('orders.deleted_at', null)
        ->where('orders.active', 1)
        ->where('orders.svodnaya_id', $this->svodnaya_id)
        ->groupBy('settlements.id')
        ->get();

        return $table;
    }

    public function getCsv()
    {
        $table = $this->getTable();

        if (sizeof($table) == 0) return '';

        $str_search = ",";
        $str_replace = ";";

        $arr_keys = [
            'latitude',
            'longitude',
            'name',
            'area',
            'region',
            'qty',
        ];

        $str_trimmer = new StrTrimmer($str_search, $str_replace);

        $strfile = $str_trimmer->getString($arr_keys) . "\n";
        
        foreach ($table as $value) {
            $str = $str_trimmer->getStringKeys($value, $arr_keys);

            $strfile .= $str . "\n";
        }

        $filename = $this->getFileName();

        file_put_contents($filename , $strfile);

        return $filename;
    }



}